<!-- Form Laporan Sampah Component -->
<!-- Used by: create.blade.php, edit.blade.php -->
<form method="POST" action="{{ $action }}" class="space-y-6" enctype="multipart/form-data" id="reportForm">
    @csrf
    @if(isset($report))
        @method('PUT')
    @endif

    <!-- Judul Laporan -->
    <div>
        <label class="block text-sm font-semibold text-gray-600 mb-2">Judul Laporan *</label>
        <input type="text" 
               name="judul" 
               value="{{ old('judul', $report->judul ?? '') }}" 
               required 
               placeholder="Contoh: Tempat sampah penuh di area TPS Kebon Jeruk" 
               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition @error('judul') border-red-500 @enderror">
        @error('judul')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Deskripsi -->
    <div>
        <label class="block text-sm font-semibold text-gray-600 mb-2">Deskripsi *</label>
        <textarea name="deskripsi" 
                  rows="6" 
                  required 
                  placeholder="Jelaskan detail laporan Anda..." 
                  class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none resize-none transition @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $report->deskripsi ?? '') }}</textarea>
        @error('deskripsi')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Detail Alamat -->
    <div>
        <label class="block text-sm font-semibold text-gray-600 mb-2">Detail Alamat *</label>
        <textarea name="detail_alamat" 
                  rows="4" 
                  required 
                  placeholder="Contoh: Jalan Diponegoro No. 45, depan warung Pak Haji, dekat pohon mangga besar..." 
                  class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none resize-none transition @error('detail_alamat') border-red-500 @enderror">{{ old('detail_alamat', $report->detail_alamat ?? '') }}</textarea>
        <p class="text-gray-400 text-xs mt-1">Berikan detail lokasi yang spesifik untuk memudahkan tim kami menemukan lokasi</p>
        @error('detail_alamat')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Foto Laporan -->
    <div>
        <label class="block text-sm font-semibold text-gray-600 mb-2">Foto Laporan 
            @if(!isset($report))
                <span class="text-red-500">*</span>
            @else
                <span class="text-gray-400 font-normal">(opsional untuk update)</span>
            @endif
        </label>
        
        <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center cursor-pointer hover:border-green-500 transition" 
             id="dropZone">
            <input type="file" 
                   name="foto_laporan" 
                   id="fotoInput" 
                   accept="image/jpeg,image/png,image/jpg" 
                   class="hidden"
                   @if(!isset($report)) required @endif>
            
            <div id="uploadPrompt">
                <p class="text-gray-600 font-semibold mb-1">📸 Klik atau drag foto kesini</p>
                <p class="text-gray-400 text-xs">JPG, JPEG, PNG maksimal 2 MB</p>
            </div>
            
            <div id="fileInfo" class="hidden">
                <p class="text-green-600 font-semibold mb-2">✅ File terpilih</p>
                <p id="fileName" class="text-gray-600 text-sm mb-3"></p>
            </div>
        </div>

        <!-- Preview Foto -->
        <div id="previewContainer" class="mt-4">
            @if(isset($report) && $report->foto_laporan)
                <div id="oldPhotoPreview" class="mb-4 p-4 bg-gray-50 rounded-xl">
                    <p class="text-xs font-semibold text-gray-600 mb-2">Foto Saat Ini:</p>
                    <img src="{{ asset('storage/' . $report->foto_laporan) }}" 
                         alt="Foto Laporan" 
                         class="w-full h-64 object-cover rounded-lg">
                </div>
            @endif
            
            <div id="newPhotoPreview" class="hidden p-4 bg-blue-50 rounded-xl">
                <p class="text-xs font-semibold text-blue-600 mb-2">Foto Baru:</p>
                <img id="previewImage" src="" alt="Preview" class="w-full h-64 object-cover rounded-lg">
            </div>
        </div>

        @error('foto_laporan')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
    </div>

    <!-- Action Buttons -->
    <div class="flex gap-3">
        <button type="submit" 
                class="flex-1 bg-sipilah-green text-white py-3 rounded-xl font-bold text-sm hover:bg-green-700 transition shadow-sm">
            @if(isset($report))
                ✏️ Perbarui Laporan
            @else
                📤 Kirim Laporan
            @endif
        </button>
        <a href="{{ route('reports.index') }}" 
           class="px-6 py-3 bg-gray-100 text-gray-600 rounded-xl font-bold text-sm hover:bg-gray-200 transition text-center">
            Batal
        </a>
    </div>
</form>

<script>
    // File upload handling
    const dropZone = document.getElementById('dropZone');
    const fotoInput = document.getElementById('fotoInput');
    const fileInfo = document.getElementById('fileInfo');
    const uploadPrompt = document.getElementById('uploadPrompt');
    const fileName = document.getElementById('fileName');
    const previewImage = document.getElementById('previewImage');
    const newPhotoPreview = document.getElementById('newPhotoPreview');
    const oldPhotoPreview = document.getElementById('oldPhotoPreview');
    const reportForm = document.getElementById('reportForm');

    const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2 MB

    // Click to upload
    dropZone.addEventListener('click', () => fotoInput.click());

    // Handle file selection
    fotoInput.addEventListener('change', handleFileSelect);

    // Drag and drop
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-green-500', 'bg-green-50');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('border-green-500', 'bg-green-50');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-green-500', 'bg-green-50');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fotoInput.files = files;
            handleFileSelect();
        }
    });

    function handleFileSelect() {
        const file = fotoInput.files[0];
        
        if (!file) return;

        // Validate file type
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!validTypes.includes(file.type)) {
            alert('❌ Hanya JPG, JPEG, dan PNG yang diizinkan');
            fotoInput.value = '';
            resetFileDisplay();
            return;
        }

        // Validate file size
        if (file.size > MAX_FILE_SIZE) {
            alert(`❌ Ukuran foto maksimal 2 MB. File Anda: ${(file.size / 1024 / 1024).toFixed(2)} MB`);
            fotoInput.value = '';
            resetFileDisplay();
            return;
        }

        // Show file info
        fileName.textContent = `${file.name} (${(file.size / 1024).toFixed(2)} KB)`;
        uploadPrompt.classList.add('hidden');
        fileInfo.classList.remove('hidden');

        // Show preview
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImage.src = e.target.result;
            newPhotoPreview.classList.remove('hidden');
            if (oldPhotoPreview) {
                oldPhotoPreview.classList.add('hidden');
            }
        };
        reader.readAsDataURL(file);
    }

    function resetFileDisplay() {
        uploadPrompt.classList.remove('hidden');
        fileInfo.classList.add('hidden');
        newPhotoPreview.classList.add('hidden');
        if (oldPhotoPreview) {
            oldPhotoPreview.classList.remove('hidden');
        }
    }

    // Form submission validation
    reportForm.addEventListener('submit', (e) => {
        const file = fotoInput.files[0];
        
        @if(!isset($report))
            // For create: file is required
            if (!file) {
                e.preventDefault();
                alert('❌ Foto laporan harus diunggah');
                return;
            }
        @endif

        if (file && file.size > MAX_FILE_SIZE) {
            e.preventDefault();
            alert(`❌ Ukuran foto maksimal 2 MB. File Anda: ${(file.size / 1024 / 1024).toFixed(2)} MB`);
            return;
        }
    });
</script>

<!-- Admin Feedback Form Component -->
<form method="POST" action="{{ route('admin.reports.feedback.store', $report->id) }}" class="space-y-6" enctype="multipart/form-data" id="feedbackForm">
    @csrf

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm font-medium">
            <p class="font-bold mb-1">⚠️ Terdapat kesalahan:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Deskripsi Hasil Penanganan -->
    <div>
        <label class="block text-sm font-semibold text-gray-600 mb-2">Deskripsi Hasil Penanganan *</label>
        <textarea name="description" 
                  rows="6" 
                  required 
                  placeholder="Jelaskan hasil penanganan laporan sampah. Contoh: Tempat sampah sudah diperbaiki dan diisi kembali..."
                  class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none resize-none transition @error('description') border-red-500 @enderror">{{ old('description', $feedback->description ?? '') }}</textarea>
        <p class="text-gray-400 text-xs mt-1">Berikan penjelasan detail tentang tindak lanjut yang telah dilakukan</p>
        @error('description')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Foto Hasil Penanganan -->
    <div>
        <label class="block text-sm font-semibold text-gray-600 mb-2">Foto Hasil Penanganan (opsional)</label>
        
        <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center cursor-pointer hover:border-green-500 transition" 
             id="dropZone">
            <input type="file" 
                   name="photo" 
                   id="photoInput" 
                   accept="image/jpeg,image/png,image/jpg" 
                   class="hidden">
            
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
            @if(isset($feedback) && $feedback->photo)
                <div id="oldPhotoPreview" class="mb-4 p-4 bg-gray-50 rounded-xl">
                    <p class="text-xs font-semibold text-gray-600 mb-2">Foto Saat Ini:</p>
                    <img src="{{ asset('storage/' . $feedback->photo) }}" 
                         alt="Foto Feedback" 
                         class="w-full h-64 object-cover rounded-lg">
                </div>
            @endif
            
            <div id="newPhotoPreview" class="hidden p-4 bg-blue-50 rounded-xl">
                <p class="text-xs font-semibold text-blue-600 mb-2">Foto Baru:</p>
                <img id="previewImage" src="" alt="Preview" class="w-full h-64 object-cover rounded-lg">
            </div>
        </div>

        @error('photo')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row gap-3">
        <button type="submit" 
                class="w-full sm:flex-1 bg-green-600 text-white py-3 rounded-xl font-bold text-sm hover:bg-green-700 transition shadow-sm">
            💾 Simpan Feedback
        </button>
        <a href="{{ route('admin.reports') }}" 
           class="w-full sm:w-auto px-6 py-3 bg-gray-100 text-gray-600 rounded-xl font-bold text-sm hover:bg-gray-200 transition text-center">
            Batal
        </a>
    </div>
</form>

<script>
    // File upload handling
    const dropZone = document.getElementById('dropZone');
    const photoInput = document.getElementById('photoInput');
    const fileInfo = document.getElementById('fileInfo');
    const uploadPrompt = document.getElementById('uploadPrompt');
    const fileName = document.getElementById('fileName');
    const previewImage = document.getElementById('previewImage');
    const newPhotoPreview = document.getElementById('newPhotoPreview');
    const oldPhotoPreview = document.getElementById('oldPhotoPreview');
    const feedbackForm = document.getElementById('feedbackForm');

    const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2 MB

    // Click to upload
    dropZone.addEventListener('click', () => photoInput.click());

    // Handle file selection
    photoInput.addEventListener('change', handleFileSelect);

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
            photoInput.files = files;
            handleFileSelect();
        }
    });

    function handleFileSelect() {
        const file = photoInput.files[0];
        
        if (!file) return;

        // Validate file type
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!validTypes.includes(file.type)) {
            alert('❌ Hanya JPG, JPEG, dan PNG yang diizinkan');
            photoInput.value = '';
            resetFileDisplay();
            return;
        }

        // Validate file size
        if (file.size > MAX_FILE_SIZE) {
            alert(`❌ Ukuran foto maksimal 2 MB. File Anda: ${(file.size / 1024 / 1024).toFixed(2)} MB`);
            photoInput.value = '';
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
    feedbackForm.addEventListener('submit', (e) => {
        const file = photoInput.files[0];
        
        if (file && file.size > MAX_FILE_SIZE) {
            e.preventDefault();
            alert(`❌ Ukuran foto maksimal 2 MB. File Anda: ${(file.size / 1024 / 1024).toFixed(2)} MB`);
            return;
        }
    });
</script>

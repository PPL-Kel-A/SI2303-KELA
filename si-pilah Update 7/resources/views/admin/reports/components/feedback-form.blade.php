<!-- Admin Feedback Form Component -->
<form method="POST" action="{{ route('admin.reports.feedback.store', $report->id) }}" class="space-y-6" enctype="multipart/form-data" id="feedbackForm">
    @csrf

    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-4 rounded">
            <p class="font-bold mb-2">⚠️ Terdapat kesalahan:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Deskripsi Hasil Penanganan -->
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-3">
            <span class="flex items-center gap-2">
                <span>📝 Deskripsi Hasil Penanganan</span>
                <span class="text-red-500">*</span>
            </span>
        </label>
        <textarea name="description" 
                  rows="7" 
                  required 
                  placeholder="Jelaskan hasil penanganan laporan sampah dengan detail. Contoh: Tempat sampah sudah diperbaiki, sampah dibersihkan, dan area sekitar telah dirapikan..."
                  class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none resize-none transition @error('description') border-red-500 ring-2 ring-red-300 @enderror">{{ old('description', $feedback->description ?? '') }}</textarea>
        <p class="text-gray-500 text-xs mt-2">Penjelasan yang detail akan membantu user memahami tindak lanjut yang sudah dilakukan</p>
        @error('description')
            <p class="text-red-500 text-xs mt-2 font-semibold">{{ $message }}</p>
        @enderror
    </div>

    <!-- Foto Hasil Penanganan -->
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-3">
            <span class="flex items-center gap-2">
                <span>📸 Foto Hasil Penanganan</span>
                <span class="text-gray-400 text-xs font-normal">(Opsional)</span>
            </span>
        </label>
        
        <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center cursor-pointer hover:border-green-500 hover:bg-green-50 transition duration-200" 
             id="dropZone">
            <input type="file" 
                   name="photo" 
                   id="photoInput" 
                   accept="image/jpeg,image/png,image/jpg" 
                   class="hidden">
            
            <div id="uploadPrompt">
                <p class="text-gray-700 font-semibold mb-2 text-lg">🖼️ Klik atau Drag Foto Kesini</p>
                <p class="text-gray-500 text-sm">JPG, JPEG, PNG | Maksimal 2 MB</p>
            </div>
            
            <div id="fileInfo" class="hidden">
                <p class="text-green-600 font-semibold mb-2 text-lg">✅ File Terpilih</p>
                <p id="fileName" class="text-gray-700 text-sm mb-3 font-medium"></p>
                <button type="button" onclick="document.getElementById('photoInput').click()" class="text-green-600 text-sm hover:underline">
                    Ganti File
                </button>
            </div>
        </div>

        <!-- Preview Foto -->
        <div id="previewContainer" class="mt-4">
            @if(isset($feedback) && $feedback->photo)
                <div id="oldPhotoPreview" class="mb-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
                    <p class="text-xs font-semibold text-gray-600 mb-3">Foto Saat Ini:</p>
                    <img src="{{ asset('storage/' . $feedback->photo) }}" 
                         alt="Foto Feedback" 
                         class="w-full h-64 object-cover rounded-lg shadow-sm">
                </div>
            @endif
            
            <div id="newPhotoPreview" class="hidden p-4 bg-blue-50 rounded-xl border border-blue-200">
                <p class="text-xs font-semibold text-blue-600 mb-3">Foto Baru:</p>
                <img id="previewImage" src="" alt="Preview" class="w-full h-64 object-cover rounded-lg shadow-sm">
            </div>
        </div>

        @error('photo')
            <p class="text-red-500 text-xs mt-2 font-semibold">{{ $message }}</p>
        @enderror
    </div>

    <!-- Action Buttons -->
    <div class="flex gap-3 pt-4 border-t border-gray-200">
        <button type="submit" 
                class="flex-1 bg-gradient-to-r from-green-600 to-green-700 text-white py-3 rounded-xl font-bold text-sm hover:from-green-700 hover:to-green-800 transition shadow-md hover:shadow-lg">
            💾 Simpan Feedback
        </button>
        <a href="{{ route('admin.reports') }}" 
           class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-bold text-sm hover:bg-gray-200 transition">
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
        fileName.textContent = `${file.name} • ${(file.size / 1024).toFixed(2)} KB`;
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

@props([
    'name',
    'label' => 'Choose File',
    'accept' => 'image/*',
    'multiple' => false
])

<div class="file-upload-container">
    <label class="file-upload-label">
        <div class="file-upload-content">
            <i class="fas fa-cloud-upload-alt text-blue-500 text-xl mb-2"></i>
            <span class="file-upload-text">{{ $label }}</span>
            <span class="file-upload-hint">Click to browse</span>
        </div>
        <input 
            type="file" 
            name="{{ $name }}" 
            accept="{{ $accept }}"
            {{ $multiple ? 'multiple' : '' }}
            class="file-upload-input"
            {{ $attributes }}
        >
    </label>
    
    {{-- Preview area --}}
    <div class="file-preview-container mt-3 hidden">
        <div class="file-preview-grid"></div>
    </div>
</div>

<style>
.file-upload-container {
    width: 100%;
}

.file-upload-label {
    display: block;
    width: 100%;
    padding: 2rem;
    border: 2px dashed #d1d5db;
    border-radius: 0.75rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #f9fafb;
}

.file-upload-label:hover {
    border-color: #3b82f6;
    background: #f0f9ff;
}

.file-upload-content {
    pointer-events: none;
}

.file-upload-text {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.file-upload-hint {
    font-size: 0.875rem;
    color: #6b7280;
}

.file-upload-input {
    display: none;
}

.file-preview-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    gap: 0.5rem;
}

.file-preview-item {
    position: relative;
    border-radius: 0.5rem;
    overflow: hidden;
}

.file-preview-image {
    width: 100%;
    height: 100px;
    object-fit: cover;
}

.file-preview-remove {
    position: absolute;
    top: 0.25rem;
    right: 0.25rem;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    border: none;
    border-radius: 50%;
    width: 1.5rem;
    height: 1.5rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInputs = document.querySelectorAll('.file-upload-input');
    
    fileInputs.forEach(input => {
        const container = input.closest('.file-upload-container');
        const previewContainer = container.querySelector('.file-preview-container');
        const previewGrid = container.querySelector('.file-preview-grid');
        const label = container.querySelector('.file-upload-label');
        
        input.addEventListener('change', function(e) {
            previewGrid.innerHTML = '';
            
            if (this.files && this.files.length > 0) {
                previewContainer.classList.remove('hidden');
                
                Array.from(this.files).forEach((file, index) => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            const previewItem = document.createElement('div');
                            previewItem.className = 'file-preview-item';
                            
                            previewItem.innerHTML = `
                                <img src="${e.target.result}" alt="${file.name}" class="file-preview-image">
                                <button type="button" class="file-preview-remove" data-index="${index}">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            `;
                            
                            previewGrid.appendChild(previewItem);
                            
                            // Remove button functionality
                            previewItem.querySelector('.file-preview-remove').addEventListener('click', function() {
                                // Create new FileList without the removed file
                                const dt = new DataTransfer();
                                Array.from(input.files).forEach((f, i) => {
                                    if (i !== parseInt(this.dataset.index)) {
                                        dt.items.add(f);
                                    }
                                });
                                input.files = dt.files;
                                previewItem.remove();
                                
                                if (input.files.length === 0) {
                                    previewContainer.classList.add('hidden');
                                }
                            });
                        };
                        
                        reader.readAsDataURL(file);
                    }
                });
            } else {
                previewContainer.classList.add('hidden');
            }
        });
        
        // Drag and drop functionality
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            label.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            label.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            label.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            label.classList.add('bg-blue-50', 'border-blue-300');
        }
        
        function unhighlight() {
            label.classList.remove('bg-blue-50', 'border-blue-300');
        }
        
        label.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            input.files = files;
            input.dispatchEvent(new Event('change'));
        }
    });
});
</script>
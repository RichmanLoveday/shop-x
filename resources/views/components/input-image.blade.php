@props(['image', 'id', 'imageUpload', 'name', 'previewImage'])

<div {{ $attributes->merge(['class' => 'upload-card' . ($image ? ' has-image' : '')]) }}>
    <input name="{{ $name }}" type="file" id="{{ $imageUpload }}" accept="image/*" />

    <div class="upload-content">
        <span class="upload-icon">📁</span>
        <p class="upload-text">Click or drag image to upload</p>
    </div>

    <img id="{{ $id }}" class="{{ $previewImage }}" src="{{ $image }}" alt="Preview" />
</div>

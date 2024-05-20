<div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" class="form-control" name="name">
</div>
<div class="mb-3">
    <label class="form-label">Prompt</label>
    <textarea class="form-control" name="prompt"></textarea>
</div>
<div class="mb-3">
    <label class="form-label">Data source type Url</label>
    <input type="text" class="form-control" name="url[]">
</div>

<div class="mb-3">
    <label class="form-label">Data source type File</label>
    <input type="file" class="form-control" name="file[]" multiple>
</div>

<div class="text-end">
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="{{ url('/') }}">
        <button type="button" class="btn btn-secondary">Cancel</button>
    </a>
</div>

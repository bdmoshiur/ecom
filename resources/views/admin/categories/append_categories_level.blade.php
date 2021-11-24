<div class="form-group">
    <label>Select Category Level</label>
    <select name="parent_id" id="parent_id" class="form-control select2" style="width: 100%;">
        <option value="0">Main Category</option>
        @if (!empty($getCategories))
            @foreach ($getCategories as $category)
                <option value="">{{ $category['category_name'] }}</option>
            @endforeach
        @endif
    </select>
</div>

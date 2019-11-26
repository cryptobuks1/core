<div class="card">
    <div class="card-header">
        <h3 class="card-title">Thêm danh mục mới</h3>
    </div>
    <div class="card-body">
        {!! Form::open(['route' => 'product-branded.store', 'id' => 'category-add-form', 'class'=>'horizontal']) !!}

        <div class="form-group">
            <label for="name">Tên * :</label>
            <input class="form-control" placeholder="Enter Name" data-rule-maxlength="256" required="1" name="name" type="text" value="{{ old('name') }}" aria-required="true">
        </div>
        <div class="form-group">
            <label for="slug">Slug* :</label>
            <input class="form-control" placeholder="Enter Slug" data-rule-maxlength="256" data-rule-unique="true"  required="1" name="slug" type="text" value="{{ old('slug') }}" aria-required="true">
        </div>
        <div class="form-group">
            <div class="row">
                <label for="parent">Danh mục  :</label>
                <select name="cat_id[]" id="cat_id" class="form-control select2"
                        multiple="multiple" data-placeholder="Select a Tag">
                    @foreach($cats as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                <script type="text/javascript">
                    $(function () {
                        //Initialize Select2 Elements
                        $('.select2').select2();
                    })
                </script>
            </div>
        </div>

        <div class="form-group">
            <label for="ckfinder-image">Ảnh danh mục :</label>
            <input class="form-control" placeholder="Enter Ảnh danh mục" id="ckfinder-image" onclick="selectFileWithCKFinder(&quot;ckfinder-image&quot;)" name="image" type="text" value="">
        </div>
        <div class="form-group">
            <label for="status">Trạng thái:</label>
            <input name="status" type="checkbox" value="status" data-toggle="toggle" style="display: none;">
            <div class="Switch Round Off" style="vertical-align:top;margin-left:10px;">
                <div class="Toggle"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="description">Mô tả :</label>
            <textarea class="form-control" placeholder="Enter Description" cols="30" rows="3" name="description" id="content">{{ old('description') }}</textarea>
        </div>
        {!! Form::submit( 'Submit', ['class'=>'btn btn-success pull-right']) !!}
        {!! Form::close() !!}
    </div>

</div>

<script>
    $(function () {
        $('input[name="name"]').on('input', function() {

            var slug = function(str) {
                str = str.replace(/^\s+|\s+$/g, ''); // trim
                str = str.toLowerCase();

                // remove accents, swap ñ for n, etc
                var from = "ãàáảạäâấầẫẩậăặắẳẵằđẻẹẽèéëêếềểễệìíỉĩịïîọõỏõòóöôốồổỗộơớờởỡợụũủùúüûưứừửữựñç·/_,:;";
                var to   = "aaaaaaaaaaaaaaaaaadeeeeeeeeeeeeiiiiiiiooooooooooooooooooouuuuuuuuuuuuunc------";
                for (var i=0, l=from.length ; i<l ; i++) {
                    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
                }
                str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                    .replace(/\s+/g, '-') // collapse whitespace and replace by -
                    .replace(/-+/g, '-'); // collapse dashes
                return str;
            };

            var slug = slug( $(this).val() );
            $('input[name="slug"]').val(slug);

        });
    });
</script>

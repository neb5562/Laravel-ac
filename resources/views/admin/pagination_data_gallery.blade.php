@forelse($images as $image)
    <div class="gallery_product  m-2">
        <div class="gallery_item_actions">
            <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="submit" class="btn btn-success text-white" onclick="javacript:addimage('{{ $product_id }}','{{$image->image_id}}');"><i class="fas fa-plus"></i></button>
            </div>
        </div>
        <img src="{{ asset('/images/'.$image->image_id.'-263.jpg') }}" class="img-responsive">
    </div>
@empty
    <p>სურათები არ მოიძებნა</p>
@endforelse
<div class="d-flex justify-content-center gallery-pagination-ajax">
    {{ $images->links() }}
</div>

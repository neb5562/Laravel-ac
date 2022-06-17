@extends('layouts.admin')

@section('content')


<div class="page-wrapper">
    <div class="white-box">
<div class="container-fluid ">
    <div class="row">
        <div class="gallery col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-2">
            <h1 class="gallery-title">Gallery</h1>
        </div>
        @forelse($images as $image)


            <div class="modal fade" id="downloadImageModal{{ $image->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">გადმოწერა: აირჩიეთ სურათის ზომა</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img src="{{ asset('/images/'.$image->image_id.'-132.jpg') }}" class="img-responsive">
                            <br>
                            <a href="{{ route('admin.downloadImage',['image' => $image->id, 'quality' => '132']) }}" class="btn btn-secondary btn-sm text-white">პატარა</a>
                            <a href="{{ route('admin.downloadImage',['image' => $image->id, 'quality' => '263']) }}" class="btn btn-secondary btn-sm text-white">საშუალო</a>
                            <a href="{{ route('admin.downloadImage',['image' => $image->id, 'quality' => '555']) }}" class="btn btn-secondary btn-sm text-white">დიდი</a>
                            <a href="{{ route('admin.downloadImage',['image' => $image->id, 'quality' => 'original']) }}" class="btn btn-secondary btn-sm text-white">ორიგინალი</a>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark text-white" data-bs-dismiss="modal">დახურვა</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="shareImageModal{{ $image->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">აირჩიეთ გასაზიარებელი მეთოდი</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img src="{{ asset('/images/'.$image->image_id.'-132.jpg') }}" class="img-responsive">
                            <br>
                            <div class="input-group mb-3">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">პირდაპირი ლინკი</button>
                                <ul class="dropdown-menu">
                                    <li onclick = "document.getElementById('img_url_{{ $image->id }}').value = '{{ asset("images/".$image->image_id."-132.jpg") }}';" ><a class="dropdown-item" href="#">პატარა</a></li>
                                    <li onclick = "document.getElementById('img_url_{{ $image->id }}').value = '{{ asset("images/".$image->image_id."-263.jpg") }}';"><a class="dropdown-item" href="#">საშუალო</a></li>
                                    <li onclick = "document.getElementById('img_url_{{ $image->id }}').value = '{{ asset("images/".$image->image_id."-555.jpg") }}';"><a class="dropdown-item" href="#">დიდი</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li onclick = "document.getElementById('img_url_{{ $image->id }}').value = '{{ asset("images/".$image->image_id."-original.jpg") }}';"><a class="dropdown-item" href="#">ორიგინალი</a></li>
                                </ul>
                                <input onClick="this.select();" id="img_url_{{ $image->id }}" type="text" class="form-control" aria-label="Text input with dropdown button">
                            </div>

                            <div class="input-group mb-3">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">სურათის თეგი</button>
                                <ul class="dropdown-menu">
                                    <li onclick = "document.getElementById('img_url_tag_{{ $image->id }}').value = '<img src=\'{{  asset("images/".$image->image_id."-132.jpg") }}\' />';"> <a class="dropdown-item" href="#">პატარა</a></li>
                                    <li onclick = "document.getElementById('img_url_tag_{{ $image->id }}').value = '<img src=\'{{  asset("images/".$image->image_id."-263.jpg") }}\' />';"><a class="dropdown-item" href="#">საშუალო</a></li>
                                    <li onclick = "document.getElementById('img_url_tag_{{ $image->id }}').value = '<img src=\'{{  asset("images/".$image->image_id."-555.jpg") }}\' />';"><a class="dropdown-item" href="#">დიდი</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li onclick = "document.getElementById('img_url_tag_{{ $image->id }}').value = '<img src=\'{{  asset("images/".$image->image_id."-original.jpg") }}\' />';"><a class="dropdown-item" href="#">ორიგინალი</a></li>
                                </ul>
                                <input onClick="this.select();" id="img_url_tag_{{ $image->id }}" type="text" class="form-control" aria-label="Text input with dropdown button">
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark text-white" data-bs-dismiss="modal">დახურვა</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="gallery_product col-lg-2 col-md-3 col-sm-4 col-xs-6  mb-3">
                <div class="gallery_item_actions">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button class="btn btn-primary btn-sm text-white"  data-bs-toggle="modal" data-bs-target="#shareImageModal{{ $image->id }}"><i class="fas fa-share-alt"></i></button>
                        <button class="btn btn-success btn-sm text-white" data-bs-toggle="modal" data-bs-target="#downloadImageModal{{ $image->id }}"><i class="fas fa-download"></i></button>
                        <form action="{{ route('admin.deleteImage') }}" method="post">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" name="id" value="{{ $image->id }}">
                            <button type="submit" class="btn btn-danger btn-sm text-white"><i class="far fa-trash-alt"></i></button>
                        </form>

                    </div>
                </div>
                <img src="{{ asset('/images/'.$image->image_id.'-263.jpg') }}" class="img-responsive">
            </div>
        @empty
        @endforelse

    </div>
</div>
        <div class="d-flex justify-content-center">
            {{ $images->links() }}
        </div>
</div>
</div>
@endsection


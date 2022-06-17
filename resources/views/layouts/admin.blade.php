<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords"
        content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Ample lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Ample admin lite dashboard bootstrap 5 dashboard template">
    <meta name="description"
        content="Ample Admin Lite is powerful and clean admin dashboard template, inpired from Bootstrap Framework">
    <meta name="robots" content="noindex,nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Apolines Cuisine - admin</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png') }}">
    <!-- Custom CSS -->
    <link href="{{ asset('js/plugins/bower_components/chartist/dist/chartist.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('js/plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css') }} ">
    <!-- Custom CSS -->
    <link href="{{ asset('css/adminstyle.css') }}" rel="stylesheet">
    <link href="{{ asset('css/cropper.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/selectize.default.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .ck-editor__editable_inline {
            min-height: 400px;
        }
    </style>
<script>
    var ImagesToDelete = [];
    var elems = {};
    var elemsId = 0;
    var ImagesToAdd = [];
    function SetImagesToDelete(val)
    {
        ImagesToDelete.push(val);
        document.getElementById("img-prev-area-"+val).remove();
        document.getElementById("imagesToDelete").value =  JSON.stringify(ImagesToDelete);
    }

    function ReconsiderAddImage(e,val)
    {
        delete elems[val];
        var elemsResult = Object.keys(elems).map((key) => [Number(key), elems[key]]);
        $('#CroppedImage64').val(JSON.stringify(elemsResult));
        e.parentNode.parentNode.remove();
    }
    function ReconsiderAddImageGallery(e,val)
    {
        delete ImagesToAdd[val];
        var elemsResult = Object.keys(ImagesToAdd).map((key) => [Number(key), ImagesToAdd[key]]);
        $('#imagesToAdd').val(JSON.stringify(elemsResult));
        e.parentNode.parentNode.remove();
    }
</script>
</head>

<body>
@if (session('status'))

<div class="modal" tabindex="-1" id="globalmessagemodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ყურადღება</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>{{ session('status') }}</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">კარგი</button>
      </div>
    </div>
  </div>
</div>


	<div class="modal show" id="globalmessagemodal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">ყურადღება</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">

		</div>
		<div class="modal-footer justify-content-center">
			<button type="button" class="button button-login w-20" data-dismiss="modal">კარგი</button>
		</div>
		</div>
	</div>
	</div>
	@endif
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin6">
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="dashboard.html">
                        <!-- Logo icon -->
                        <b class="logo-icon">
                            <!-- Dark Logo icon -->
                            <img src="{{asset('js/plugins/images/logo-icon.png')}}" alt="homepage" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span class="logo-text">
                            <!-- dark Logo text -->
                            <img src="{{asset('js/plugins/images/logo-text.png')}}" alt="homepage" />
                        </span>
                    </a>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <a class="nav-toggler waves-effect waves-light text-dark d-block d-md-none"
                        href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">

                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav ms-auto d-flex align-items-center">

                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <!--
                        <li class=" in">
                            <form role="search" class="app-search d-none d-md-block me-3">
                                <input type="text" placeholder="Search..." class="form-control mt-0">
                                <a href="" class="active">
                                    <i class="fa fa-search"></i>
                                </a>
                            </form>
                        </li>
                        -->
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li>
                            <a class="profile-pic" href="{{ route('admin.index') }}">
                                <span class="text-white font-medium">გამარჯობა: {{ auth()->user()->username }}</span></a>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <!-- User Profile-->
                        <li class="sidebar-item pt-2">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->routeIs('admin.index') ? 'active' : ''}}" href="{{ route('admin.index') }}"
                                aria-expanded="false">
                                <i class="fas fa-chess"></i>
                                <span class="hide-menu">ადმინ პანელი</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->routeIs('admin.index') ? 'active' : ''}}" href="{{ route('admin.index') }}"
                                aria-expanded="false">
                                <i class="fas fa-shopping-cart" aria-hidden="true"></i>
                                <span class="hide-menu">გაყიდვები</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->routeIs('admin.products') ? 'active' : ''}}" href="{{ route('admin.products') }}"
                                aria-expanded="false">
                                <i class="fas fa-list-alt" aria-hidden="true"></i>
                                <span class="hide-menu">პროდუქცია</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->routeIs('admin.ProductsOffs') ? 'active' : ''}}" href="{{ route('admin.ProductsOffs') }}"
                                aria-expanded="false">
                                <i class="fas fa-tag" aria-hidden="true"></i>
                                <span class="hide-menu">ფასდაკლებები</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->routeIs('admin.showPosts') ? 'active' : ''}}" href="{{ route('admin.showPosts') }}"
                                aria-expanded="false">
                                <i class="fab fa-blogger-b"></i>
                                <span class="hide-menu">ბლოგი</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->routeIs('admin.users') ? 'active' : ''}}" href="{{ route('admin.users') }}"
                                aria-expanded="false">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span class="hide-menu">მომხმარებლები</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->routeIs('admin.gallery') ? 'active' : ''}}" href="{{ route('admin.gallery') }}"
                               aria-expanded="false">
                                <i class="fas fa-images"></i>
                                <span class="hide-menu">გალერეა</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link {{ request()->routeIs('admin.fucks') ? 'active' : ''}}" href="{{ route('admin.fucks') }}"
                               aria-expanded="false">
                                <i class="fas fa-question-circle"></i>
                                <span class="hide-menu">ხ.დ.კ</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('admin.index') }}"
                                aria-expanded="false">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                <span class="hide-menu">Error 404</span>
                            </a>
                        </li>
                        <li class="text-center p-20 upgrade-btn">
                            <a href="{{ route('home') }}"
                                class="btn btn-danger text-white" >
                                <i class="fas fa-chevron-circle-left"></i> საიტზე დაბრუნება</a>
                        </li>
                    </ul>

                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->


@yield('content')

            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center"> 2021 © Ample Admin brought to you by <a
                    href="https://www.wrappixel.com/">wrappixel.com</a>
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->

</body>

<!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('js/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/app-style-switcher.js') }}"></script>
    <script src="{{ asset('js/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('js/waves.js') }}"></script>
    <!--
    <script src="{{ asset('js/sidebarmenu.js') }}"></script>
    -->
    <script src="{{ asset('js/custom.js') }}"></script>
    <!--This page JavaScript -->
    <!--chartis chart-->
    <script src="{{ asset('js/cropper.js') }}"></script>
    <script src="{{ asset('js/ckeditor.js') }}"></script>
    <script src="{{ asset('js/translations/ka.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('js/locales/bootstrap-datetimepicker.ka.js') }}"></script>
    <script src="{{ asset('js/standalone/selectize.min.js') }}"></script>

<script>

    function addimage(pid,iid)
    {
        let div1 = document.createElement('div');
        div1.classList.add('img-prev-area');

        let div2 = document.createElement('div');
        div2.classList.add('img-prev-delete');

        let a = document.createElement('a');
        a.setAttribute('class', 'btn btn-danger text-white');
        a.setAttribute('data-img-key', elemsId);
        a.setAttribute('onclick',"javascript:ReconsiderAddImageGallery(this,"+elemsId+")"); // for FF
        a.innerText = 'წაშლა';

        div2.appendChild(a);
        div1.appendChild(div2);

        var imgpr = document.createElement("img");

        imgpr.setAttribute("src", "http://{{ Request::server ("SERVER_NAME") }}/images/"+iid+"-263.jpg");
        imgpr.setAttribute("height", "240");
        imgpr.setAttribute("width", "240");

        div1.appendChild(imgpr);
        document.getElementById("img-preview").appendChild(div1);
        ImagesToAdd[elemsId]={'product_id' : pid,'image_id' : iid};
        //document.getElementById("imagesToAdd").value =  JSON.stringify(ImagesToAdd);
        $('#imagesToAdd').val(JSON.stringify(ImagesToAdd));
        elemsId++;
    }
    $(document).ready(function(){

        $(document).on('click', '.gallery-pagination-ajax .pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            fetch_data(page);
        });

        function fetch_data(page)
        {
            $.ajax({
                url:"/admin/gallery/pagination/ajax?page="+page+'&pid='+{{ $product->id ?? null }},
                success:function(data)
                {
                    $('#galleryFromAjax').html(data);
                }
            });
        }

    });
</script>
<script>

    function countChars(obj,id){
        document.getElementById(id).innerHTML = obj.value.length+' სიმბოლო';
    }
</script>

<script>

    $('.select-categories').selectize();

</script>

<script type="text/javascript">
    $('form').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });
</script>

<script>
$(document).ready(function(){


    $('.product-select').select2({ width: '100%' });

    $('.off_starts_at, .off_ends_at ').datetimepicker({
        language: 'ka',
        format: 'yyyy-mm-dd hh:ii:ss',
        autoclose: true
    });



    ClassicEditor
        .create( document.querySelector( ['#product_full_description', '#blog_full_body','#answer'] ), {
            language: 'ka'
        } )
        .then( editor => {
            window.editor = editor;
        } )
        .catch( err => {
            console.error( err.stack );
        } );

    $("#globalmessagemodal").modal('show');
	var $modal = $('#cropImageModal');

	var image = document.getElementById('sample_image');

	var cropper;

	$('#productImage').change(function(event){
		var files = event.target.files;

		var done = function(url){
			image.src = url;
			$modal.modal('show');
		};

		if(files && files.length > 0)
		{
			reader = new FileReader();
			reader.onload = function(event)
			{
				done(reader.result);
			};
			reader.readAsDataURL(files[0]);
		}
	});

	$modal.on('shown.bs.modal', function() {
		cropper = new Cropper(image, {
			aspectRatio: 1,
			viewMode: 3,
			preview:'.crop-preview'
		});
	}).on('hidden.bs.modal', function(){
		cropper.destroy();
   		cropper = null;
	});

	$('#crop').click(function(){
        //console.log(cropper);
        var size = cropper.canvasData.naturalHeight ;
        if(cropper.canvasData.naturalHeight > 1000)
        {
            size = 1000;
        }
		canvas = cropper.getCroppedCanvas({
			width:size,
			height:size,
		});

		canvas.toBlob(function(blob){
			url = URL.createObjectURL(blob);
			var reader = new FileReader();
			reader.readAsDataURL(blob);
			reader.onloadend = function(){

				var base64data = reader.result;
               // elems.push({elemsId : base64data});
               elems[elemsId] = base64data;

                //console.log(elems);
                //document.getElementById("CroppedImage64").value = base64data;
                var elemsResult = Object.keys(elems).map((key) => [Number(key), elems[key]]);
                $('#CroppedImage64').val(JSON.stringify(elemsResult));

                //document.getElementById("preview-cropped").src = base64data;

                let div1 = document.createElement('div');
                div1.classList.add('img-prev-area');

                let div2 = document.createElement('div');
                div2.classList.add('img-prev-delete');

                let a = document.createElement('a');
                a.setAttribute('class', 'btn btn-danger text-white');
                //a.setAttribute('href', 'javascript:this.parentElement.parentElement.remove();');
                a.setAttribute('data-img-key', elemsId);
                a.setAttribute('onclick',"javascript:ReconsiderAddImage(this,"+elemsId+")"); // for FF
                a.innerText = 'წაშლა';

                div2.appendChild(a);
                div1.appendChild(div2);

                var imgpr = document.createElement("img");

                imgpr.setAttribute("src", base64data);
                imgpr.setAttribute("height", "240");
                imgpr.setAttribute("width", "240");

                div1.appendChild(imgpr);
                document.getElementById("img-preview").appendChild(div1);
                elemsId++;

						$modal.modal('hide');
						//console.log(data);

			};
		});
	});

});
</script>
</html>

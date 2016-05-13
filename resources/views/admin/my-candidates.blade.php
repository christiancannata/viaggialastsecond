@extends('template.admin_layout')

@section('breadcrumbs')

        <!--breadcrumbs start-->
<div id="breadcrumbs-wrapper">
    <!-- Search for small screen -->
    <div class="header-search-wrapper grey hide-on-large-only">
        <i class="mdi-action-search active"></i>
        <input type="text" name="Search" class="header-search-input z-depth-2"
               placeholder="Search for candidates">
    </div>
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Saved candidates
                </h5>
                <ol class="breadcrumbs">
                    <li><a href="/hr">Dashboard</a></li>
                    <li>Saved Candidates</li>

                </ol>
            </div>
        </div>
    </div>
</div>

<!--breadcrumbs end-->
@endsection

@section('content')

        <!-- START CONTENT -->
<section id="content">


    <!--start container-->
    <div class="container">
        <div class="section">

            <div class="row">
                <h4 class="header">Saved Candidates</h4>

                <div class="col s12 m4 l3">
                    <p>Here you can add a new category and assign it to selected candidates</p>
                </div>
                <div class="col s12 m8 l9">
                    @if(isset($company["categories"]) && count($company["categories"]) > 0)
                        <ul class="collection categories">
                            @foreach ($company["categories"] as $category)
                                <li  id="category-{{$category["id"]}}" class="collection-item avatar">
                                    <a class="black-text" href="/hr/db/candidates/{{$category["id"]}}">
                                        <i class="mdi-file-folder circle"></i>
                                        <span class="title">{{$category["title"]}}</span>

                                        <div class="clear" style="height: 3px;"></div>
                                        @if (isset($category["categories_applications"]) && count($category["categories_applications"]) > 0)
                                            <p>There are {{count($category["categories_applications"])}} candidates</p>
                                        @else
                                            <p>No candidate saved in this category</p>
                                        @endif
                                        <div class="clear" style="height: 3px;"></div>

                                        <p>
                                            <a href="javascript:;" data-id="{{$category["id"]}}" class="remove-category">Delete category</a></p>
                                    </a>

                                </li>
                            @endforeach
                        </ul>


                        <a href="#modal-new-category"
                           class="btn-floating btn-large waves-effect waves-light red right modal-trigger"><i
                                    class="mdi-content-add "></i></a>
                    @else

                        <div id="card-alert" class="card white lighten-1">
                            <div class="card-content black-text ">
                                <span class="card-title black-text ">No category added</span>
                                <p>Add your first category</p>
                            </div>
                            <div class="card-action white darken-1">
                                <a href="#modal-new-category"
                                   class="waves-effect waves-light red btn white-text modal-trigger">Add category</a>
                            </div>
                        </div>

                    @endif

                </div>

            </div>

        </div>
        <div class="divider"></div>


        @include('admin.new-category')

    </div>

    </div>
    <!--end container-->
</section>
<!-- END CONTENT -->


@endsection

@section('page-scripts')
    <script type="text/javascript" src="/js/main.js"></script>

    <script type="text/javascript" src="/admin/js/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/jquery-validation/additional-methods.min.js"></script>
    <script type="text/javascript"
            src="{{auto_version("/admin/js/my-candidates.js")}}"></script>
    <script type="text/javascript" src="/admin/js/plugins/formatter/jquery.formatter.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            MyCandidates.init();
        });


    </script>
@endsection
<!-- MODAL NEW category !-->
<div id="modal-new-category" class="modal std-modal">
    <div class="modal-content">
        <nav class="red color-result darken-1">
            <div class="nav-wrapper">
                <div class="left col s12 m5 l5">
                    <ul>

                        <li><a lang="en" href="#!" class="email-type">Add a new category</a>
                        </li>
                    </ul>
                </div>


            </div>
        </nav>
    </div>
    <div class="model-email-content color-result">
        <div class="row">


            <form id="new-category" class="col s12" method="POST" action="">
                <p>Type a name for your category (e.g. Marketing)</p>
                <div style="display: none; margin-top: 50px; margin-bottom: 50px;"
                     class="col s12 m12 l12 center form-loader">
                    <div class="preloader-wrapper big active">
                        <div class="spinner-layer spinner-red-only">
                            <div class="circle-clipper left">
                                <div class="circle"></div>
                            </div>
                            <div class="gap-patch">
                                <div class="circle"></div>
                            </div>
                            <div class="circle-clipper right">
                                <div class="circle"></div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="form-content">
                    <div class="row">
                        <div class="input-field col  l12 m12 s12">
                            <input maxlength="45" length="45" required name="categoryTitle" id="categoryTitle" type="text"
                                   class="validate">
                            <label lang="en" for="categoryTitle">Title</label>
                        </div>
                    </div>


                    <div class="input-field col s12">
                        <button lang="en"
                                class="btn waves-effect waves-light right red submit btn-add-category"
                                type="submit"
                                name="action">Add category<i class="mdi-content-add right"></i>
                        </button>
                    </div>

                </div>

                <div style="display: none; margin-top: 50px; margin-bottom: 50px;"
                     class="center form-result animated fadeIn">
                    <div class="white-text">
                        <h4 lang="en" class=""><i class="mdi-navigation-check medium"></i>&nbsp;Category
                            added
                        </h4>
                        <h6 lang="en">The category has been added successfully.<br></h6>
                    </div>
                    <div class="button-action">
                        <button type="button" data-form="new-category" lang="en"
                                class="waves-effect waves-light green darken-2 btn form-recreate-modal">Add
                            another
                        </button>
                        <button onclick="location.reload();" type="button" lang="en"
                                class="waves-effect waves-light green darken-2 btn modal-close">
                            Close
                        </button>
                    </div>

                </div>

                <div style="display: none; margin-top: 50px; margin-bottom: 50px;"
                     class="center form-result-error animated fadeIn">
                    <div class="white-text">
                        <h4 lang="en" class=""><i class="mdi-alert-error medium"></i>&nbsp;Unable to add
                            category
                        </h4>
                        <h6 class="form-result-error-text" lang="en">A server error occurred.</h6>
                    </div>
                    <div class="button-action">
                        <button type="button" data-form="new-category" lang="en"
                                class="waves-effect waves-light red darken-2 btn form-recreate-modal">Edit
                            data
                        </button>
                        <button lang="en" class="waves-effect waves-light red darken-2 btn">Try again
                        </button>
                    </div>

                </div>


            </form>
        </div>
    </div>


</div>
<!-- END MODAL NEW category !-->
@extends('layouts.app')

@section('content')

    <body ng-controller="BackEndCtl" id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('layouts.partials.menu_bar')

        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                @include('layouts.partials.nav_bar')

                <div class="container-fluid" ng-view>
                </div>

                <footer class="fixed-footer bg-white fixed-bottom">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; SAMAKEUR AVRIL 2020</span>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    </body>


    {{--    les modals ici--}}

    <div class="modal fade" id="modal_addplan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-lg" role="document"  style="max-width: 94%">
            <div class="modal-content">
                <div class="modal-header bg-gradient-dark text-white">
                    <h5 class="modal-title" id="exampleModalLongTitle">Ajouter Un Nouveau Plan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body m-3">
                    <form>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="superficie">Superficie</label>
                                    <input type="number" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="superficie">Type de Chambre</label>
                                    <select class="form-control">
                                        <option>TYPE 1</option>
                                        <option>TYPE 2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="superficie">Garage</label>
                                    <select class="form-control">
                                        <option>OUI</option>
                                        <option>NON</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="superficie">Piscine</label>
                                    <select class="form-control">
                                        <option>OUI</option>
                                        <option>NON</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="superficie">Fichier</label>
                                    <input type="file" class="form-control">
                                </div>
                            </div>
                        </div>

                       {{-- <hr>--}}
                        <h4 class="form-section animated fadeInDown mb-3 mt-5 border-bottom border-alternate">
                            <i class="fa fa-shopping-cart"></i>
                            NIVEAUX
                        </h4>
                        <div class="row">
                            <div class="card col-lg-12">
                                {{--<div class="card-header-tab card-header" align="center">
                                    Ajouter un niveau
                                </div>--}}
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="superficie">Pièces</label>
                                                <input type="number" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="superficie">Chambres</label>
                                                <input type="number" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="superficie">Bureau</label>
                                                <input type="number" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="superficie">Salon</label>
                                                <input type="number" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="superficie">Cuisine</label>
                                                <input type="number" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                <label for="superficie">Toillette</label>
                                                <input type="number" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-1">
                                            <div class="form-group mt-4">
                                                <button class="btn btn-success mt-2" title="Ajouter un niveau" >
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="table-responsive">
                                <table class="table table-responsive-sm table-bordered mb-0 text-center dataTable dtr-inline" id="tabLigneLiv" role="grid">
                                    <thead>
                                    <th class="text-center">N°</th>
                                    <th class="text-center">Pièce</th>
                                    <th class="text-center">Chambre</th>
                                    <th class="text-center">Bureau</th>
                                    <th class="text-center">Salon</th>
                                    <th class="text-center">Cuisine</th>
                                    <th class="text-center">Toillettes</th>
                                    <th class="text-center">Actions</th>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="text-center">Niveau 1</td>
                                        <td class="text-center">15</td>
                                        <td class="text-center">7</td>
                                        <td class="text-center">2</td>
                                        <td class="text-center">2</td>
                                        <td class="text-center">1</td>
                                        <td class="text-center">3</td>
                                        <td class="">
                                            <button class=" btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <button type="button" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

{{--    modal demande --}}

    <div class="modal fade" id="modal_adddemande" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-lg" role="document"  style="max-width: 94%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Ajouter Un Nouveau Projet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body m-3">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="superficie">Client</label>
                                    <select class="js-example-basic-single form-control" name="state">

                                        <option value="CL">client 2</option>
                                        <option value="AL">Alabama</option>
                                        <option value="WY">Wyoming</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="superficie">Fichier</label>
                                    <input type="file" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="superficie">Superficie</label>
                                    <input type="number" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="superficie">Type de Chambre</label>
                                    <select class="form-control">
                                        <option>TYPE 1</option>
                                        <option>TYPE 2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="superficie">Garage</label>
                                    <select class="form-control">
                                        <option>OUI</option>
                                        <option>NON</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="superficie">Piscine</label>
                                    <select class="form-control">
                                        <option>OUI</option>
                                        <option>NON</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <h4 class="form-section animated fadeInDown mb-3 mt-5 border-bottom border-alternate">
                            <i class="fa fa-shopping-cart"></i>
                            NIVEAUX
                        </h4>
                        <div class="row">
                            <div class="card col-lg-12">

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="superficie">Pièces</label>
                                                <input type="number" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="superficie">Chambres</label>
                                                <input type="number" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="superficie">Bureau</label>
                                                <input type="number" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="superficie">Salon</label>
                                                <input type="number" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="superficie">Cuisine</label>
                                                <input type="number" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                <label for="superficie">Toillette</label>
                                                <input type="number" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-1">
                                            <div class="form-group mt-4">
                                                <button class="btn btn-success mt-2" title="Ajouter un niveau" >
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-responsive-sm table-bordered mb-0 text-center dataTable dtr-inline" id="tabLigneLiv" role="grid">
                                    <thead>
                                    <th class="text-center">N°</th>
                                    <th class="text-center">Pièce</th>
                                    <th class="text-center">Chambre</th>
                                    <th class="text-center">Bureau</th>
                                    <th class="text-center">Salon</th>
                                    <th class="text-center">Cuisine</th>
                                    <th class="text-center">Toillettes</th>
                                    <th class="text-center">Actions</th>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="text-center">Niveau 1</td>
                                        <td class="text-center">15</td>
                                        <td class="text-center">7</td>
                                        <td class="text-center">2</td>
                                        <td class="text-center">2</td>
                                        <td class="text-center">1</td>
                                        <td class="text-center">3</td>
                                        <td class="">
                                            <button class=" btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection

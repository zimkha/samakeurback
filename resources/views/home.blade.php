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
                            <span>Copyright &copy; SAMAKEUR 2020</span>
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
                    <form id="form_addplan" class="form" enctype="multipart/form-data" accept-charset="UTF-8">
                        @csrf
                        <input type="hidden" id="id_plan" name="id">
                        <input type="hidden" name="tab_niveau" id="tab_niveau" value="@{{produitsInTable}}">

                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="superficie_plan">Superficie</label>
                                    <input type="number" id="superficie_plan" name="superficie" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="longeur_plan">Longeur</label>
                                    <input type="number" id="longeur_plan" name="longeur" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="largeur_plan">Largeur</label>
                                    <input type="number" id="largeur_plan" name="largeur" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="unite_mesure_plan">Unité de mesure</label>
                                    <select class="form-control" id="unite_mesure_plan" name="unite_mesure">
                                        <option value="1">Mettre carré</option>
                                        <option value="2">Hectare</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="fichier_plan">Fichier</label>
                                    <input type="file" class="form-control" id="fichier_plan" name="fichier">
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
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="niveau_plan">Designation</label>
                                                <input type="text" name="niveau" id="niveau_plan" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="piece_plan">Pièces</label>
                                                <input type="number" name="piece" id="piece_plan" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="chambre_plan">Chambres</label>
                                                <input type="number" name="chambre" id="chambre_plan" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="bureau_plan">Bureau</label>
                                                <input type="number" id="bureau_plan" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="salon_plan">Salon</label>
                                                <input type="number" name="salon" id="salon_plan" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="cuisine_plan">Cuisine</label>
                                                <input type="number" name="cuisine" id="cuisine_plan" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="toillete_plan">Toillette</label>
                                                <input type="number" name="toillete" class="form-control" id="toillete_plan">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group mt-4 text-lg-right">
                                                <button class="btn btn-success mt-2" ng-click="actionSurPlan('add')" title="Ajouter un niveau" >
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-md-12 animated fadeIn text-center" ng-if="produitsInTable.length==0">
                                    <h3> Ajouter un Niveau pour ce plan</h3>
                            </div>
                            <div class="col-md-12" ng-if="produitsInTable.length !=0">
                                <div class="table-responsive">
                                    <table class="table table-responsive-sm table-bordered mb-0 text-center dataTable dtr-inline" id="tabNiveau" role="grid">
                                        <thead>
                                        <th class="text-center">N°</th>
                                        <th class="text-center">Niveau</th>
                                        <th class="text-center">Pièce</th>
                                        <th class="text-center">Chambre</th>
                                        <th class="text-center">Bureau</th>
                                        <th class="text-center">Salon</th>
                                        <th class="text-center">Cuisine</th>
                                        <th class="text-center">Toillettes</th>
                                        <th class="text-center">Actions</th>
                                        </thead>
                                        <tbody>
                                        <tr class="animated fadeIn" ng-repeat="item in produitsInTable">
                                            <td class="text-center">
                                                1
                                            </td>
                                            <td class="text-center">
                                                @{{ item.niveau }}
                                            </td>
                                            <td class="text-center">
                                                @{{ item.piece }}
                                            </td>
                                            <td class="text-center">
                                                @{{ item.chambre }}
                                            </td>
                                            <td class="text-center">
                                                @{{ item.bureau }}
                                            </td>
                                            <td class="text-center">
                                                @{{ item.salon }}
                                            </td>
                                            <td class="text-center">
                                                @{{ item.cuisine }}
                                            </td>
                                            <td class="text-center">
                                                @{{ item.toillete }}
                                            </td>
                                            <td>
                                                <button class="btn btn-danger" ng-click="actionSurPlan('delete',item)" title="Supprimer du tableau">
                                                    <span class="fa fa-trash"></span>
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>


                        <div class="modal-footer">
                            <button type="reset" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary" ng-click="addElement($event,'plan')">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>


    <div class="modal bd-example-modal-lg  fade" id="modal_changeStattus" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true" style="background-color: rgba(43, 43, 43, .69);">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header back-dark-50 text-white border-0">
                    <div class="uk-text-bold">@{{changestatut.title}}</div>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body modal-body1">
                    <form id="modal_addchstat" class="form" accept-charset="UTF-8" ng-submit="changestatut($event,changestatut.id)">
                        @csrf
                        <div class="uk-margin">
                        </div>
                        <div class="text-right">
                            <div class="mt-30">
                                <button class="uk-button back-red shadow text-white pl-2 pr-2 lh-34 button-mat-filtrer btn--7" type="reset" data-dismiss="modal"><span class="psuedo-text"><i class="fa fa-times"></i> Non</span> </button>
                                <button class="uk-button back-dark shadow text-white pl-2 pr-2 lh-34 button-mat-valid btn--7" type="submit"> <span class="psuedo-text"><i class="fa fa-check"></i> Oui</span></button>
                            </div>
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
                    <form id="form_addprojet" class="form" enctype="multipart/form-data" accept-charset="UTF-8">
                        @csrf
                        <input type="hidden" id="id_plan" name="id">
                        <input type="hidden" name="tab_niveau" id="tab_niveau" value="@{{produitsInTable}}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="client_projet">Client</label>
                                    <select class="js-example-basic-single form-control" id="user_projet" name="user">
                                    <option diseabled="diseabled" >choisir un client</option>
                                    <option ng-repeat="item in users" ng-if="item.is_client==1 && item.active==1" value="@{{item.id}}">@{{item.name}} -- @{{item.email}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="fichier_projet">Fichier</label>
                                    <input type="file" class="form-control" id="fichier_projet" name="fichier">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="superficie_plan">Superficie</label>
                                    <input type="number" class="form-control" id="superficie_plan" name="superficie">
                                </div>
                            </div>
                           
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="longeur_projet">Longeur</label>
                                   <input type="number" class="form-control" id="longeur_projet" name="longeur">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="largeur_projet">Largeur</label>
                                   <input type="number" class="form-control" id="largeur_projet" name="largeur">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="superficie_projet">Piscine</label>
                                    <select class="form-control" id="piscine_projet" name="piscine">
                                        <option value="1">OUI</option>
                                        <option value="0">NON</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-3">
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="electricte_projet" value="">Electricté
                                  </label>
                            </div>
                            <div class="col-lg-3">
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="accesvoirie_projet" value="">Accés voirie
                                  </label>
                            </div>
                            <div class="col-lg-3">
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="ass_projet" value="">Assainissement
                                  </label>
                            </div>
                                                    <div class="col-lg-3">
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="cadastre_projet" value="">Cadastre
                                  </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                            <div class="form-group">
                                <label for="description_proje">Desciption</label>
                                <textarea rows="4" class="form-control" id="description_projet" name="description"></textarea>
                                </div>
                            </div>
                        </div>
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
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="niveau_projet">Designation</label>
                                                <input type="text" name="niveau" id="niveau_projet" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="piece_projet">Pièces</label>
                                                <input type="number" name="piece" id="piece_projet" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="chambre_projet">Chambres</label>
                                                <input type="number" name="chambre" id="chambre_projet" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="bureau_projet">Bureau</label>
                                                <input type="number" id="bureau_projet" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="salon_projet">Salon</label>
                                                <input type="number" name="salon" id="salon_projet" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="cuisine_projet">Cuisine</label>
                                                <input type="number" name="cuisine" id="cuisine_projet" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="toillete_projet">Toillette</label>
                                                <input type="number" name="toillete" class="form-control" id="toillete_projet">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group mt-4 text-lg-right">
                                                <button class="btn btn-success mt-2" ng-click="actionSurProjet('add')" title="Ajouter un niveau" >
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                       
                        <div class="row mt-5">
                            <div class="col-md-12 animated fadeIn text-center" ng-if="produitsInTable.length==0">
                                <h3> Ajouter un Niveau pour ce plan
                                </h3>
                            </div>
                            <div class="col-md-12" ng-if="produitsInTable.length !=0">
                                <div class="table-responsive">
                                    <table class="table table-responsive-sm table-bordered mb-0 text-center dataTable dtr-inline" id="tabNiveau" role="grid">
                                        <thead>
                                        <th class="text-center">N°</th>
                                        <th class="text-center">Niveau</th>
                                        <th class="text-center">Pièce</th>
                                        <th class="text-center">Chambre</th>
                                        <th class="text-center">Bureau</th>
                                        <th class="text-center">Salon</th>
                                        <th class="text-center">Cuisine</th>
                                        <th class="text-center">Toillettes</th>
                                        <th class="text-center">Actions</th>
                                        </thead>
                                        <tbody>
                                        <tr class="animated fadeIn" ng-repeat="item in produitsInTable">
                                            <td class="text-center">
                                                1
                                            </td>
                                            <td class="text-center">
                                                @{{ item.niveau }}
                                            </td>
                                            <td class="text-center">
                                                @{{ item.piece }}
                                            </td>
                                            <td class="text-center">
                                                @{{ item.chambre }}
                                            </td>
                                            <td class="text-center">
                                                @{{ item.bureau }}
                                            </td>
                                            <td class="text-center">
                                                @{{ item.salon }}
                                            </td>
                                            <td class="text-center">
                                                @{{ item.cuisine }}
                                            </td>
                                            <td class="text-center">
                                                @{{ item.toillete }}
                                            </td>
                                            <td>
                                                <button class="btn btn-danger" ng-click="actionSurProjet('delete',item)" title="Supprimer du tableau">
                                                    <span class="fa fa-trash"></span>
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" ng-click="addElement($event,'projet')">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection

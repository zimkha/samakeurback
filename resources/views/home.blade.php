@extends('layouts.app')

@section('content')

    <body ng-controller="BackEndCtl" id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <style>

            .select2-container--default .select2-selection--single {
                border-radius: 0px !important;
                color: #83B2DF !important;

            }

            .select2-container .select2-selection--single {
                box-sizing: border-box;
                cursor: pointer;
                display: block;
                height: 40px !important;
                border-radius: 5px!important;
                user-select: none;
                -webkit-user-select: none;
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 26px;
                position: absolute;
                top: 6px !important;
                right: 1px;
                width: 20px;
            }

            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 35px;
                top: 5px !important;
            }

        </style>

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
                        <input type="hidden" name="tab_plan" id="tab_plan" value="@{{produitsInTable}}">

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
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="piscine_plan">Piscine</label>
                                    <select class="form-control" id="piscine_plan" name="piscine">
                                        <option value="0">NON</option>
                                        <option value="1">OUI</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="garage_plan">Garage</label>
                                    <select class="form-control" id="garage_plan" name="garage">
                                        <option value="1">OUI</option>
                                        <option value="0">NON</option>
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
                                        <!-- <div class="col-lg-3">
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
                                        </div> -->
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="chambre_plan">Chambres simples</label>
                                                <input type="number" name="chambre" id="chambre_plan" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="chambre_sdb_plan" title="Chambre avec salle de bain">Chambres SDB</label>
                                                <input type="number" name="sdb" id="chambre_sdb_plan" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="bureau_plan">Bureau</label>
                                                <input type="number" id="bureau_plan" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="salon_plan">Salon</label>
                                                <input type="number" name="salon" id="salon_plan" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="cuisine_plan">Cuisine</label>
                                                <input type="number" name="cuisine" id="cuisine_plan" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="toillette_plan">Toillette</label>
                                                <input type="number" name="toillette" class="form-control" id="toillette_plan">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
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
                                        <!-- <th class="text-center">Pièce</th> -->
                                        <th class="text-center">Chambre Simple</th>
                                        <th class="text-center">Chambre SDB</th>
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
                                            <!-- <td class="text-center">
                                                @{{ item.piece }}
                                            </td> -->
                                            <td class="text-center">
                                                @{{ item.chambre }}
                                            </td>
                                            <td class="text-center">
                                                @{{ item.sdb }}
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
                                                @{{ item.toillette }}
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


    <div class="modal fade" id="modal_addlier_plan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-dark text-white">
                    <h5 class="modal-title" id="exampleModalLongTitle">Lier Plan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body m-3">
                    <form id="form_addlier_plan" class="form" enctype="multipart/form-data" accept-charset="UTF-8">
                        @csrf

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="client_lier_plan">Client</label>
                                    <select class="form-control select2" id="client_lier_plan" name="client">
                                        <option ng-repeat="item in users" value="@{{item.id}}">@{{item.prenom}} @{{ item.nom}} </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="projet_lier_plan">Projets</label>
                                    <select class="form-control" id="projet_lier_plan" name="projet_id">
                                        <option ng-repeat="item in projets" value="@{{item.id}}">@{{item.name}} </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    {{--    <div class="row mt-5">
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
                                                @{{ item.toillette }}
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
                        </div>--}}


                        <div class="modal-footer">
                            <button type="reset" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary" ng-click="addElement($event,'lier_plan')">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>


    <div class="modal fade" id="modal_addjoined" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-dark text-white">
                    <h5 class="modal-title" id="exampleModalLongTitle">Joindre Plan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body m-3">
                    <form id="form_addjoined" class="form" enctype="multipart/form-data" accept-charset="UTF-8">
                        @csrf

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="fichier_joined">Fichier</label>
                                    <input type="file" name="fichier" id="fichier_joined" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <textarea name="description" class="form-control" id="description_joined" placeholder="Description"></textarea>
                                </div>
                            </div>
                        </div>



                        <div class="modal-footer">
                            <button type="reset" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary" ng-click="addElement($event,'joined')">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>


    <div class="modal fade" id="modal_addchangestatut"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-md" role="document" >
            <div class="modal-content">
                <div class="modal-header bg-gradient-dark text-white">
                    <h5 class="modal-title" id="exampleModalLongTitle">@{{chstat.title}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
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
                {{--<div class="modal-body m-3">
                    <form id="form_addchstat" class="form" accept-charset="UTF-8" ng-submit="changestatut($event,chstat.type)">
                        @csrf

                        <div class="modal-footer">
                            <button type="reset" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>--}}
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
                        <input type="hidden" name="positions" id="tab_position" value="@{{positions}}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="client_projet">Client</label>
                                    <select class="js-example-basic-single form-control" id="user_projet" name="user">
                                      {{--  <option value="1">Client 1</option>
                                        <option value="2">Client 2</option>--}}
                                    <option diseabled="diseabled" >Choisir un client</option>
                                    <option ng-repeat="item in users" value="@{{item.id}}">@{{item.prenom}} @{{item.nom}}</option>
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

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="longeur_projet">Longeur</label>
                                   <input type="number" class="form-control" id="longeur_projet" name="longeur">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="largeur_projet">Largeur</label>
                                   <input type="number" class="form-control" id="largeur_projet" name="largeur">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="adresse_terrain_projet">Adresse Terrain</label>
                                    <input type="text" class="form-control" id="adresse_terrain_projet" name="adresse_terrain">
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="piscine_projet">Piscine</label>
                                    <select class="form-control" id="piscine_projet" name="piscine">
                                        <option value="0">NON</option>
                                        <option value="1">OUI</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="garage_projet">Garage</label>
                                    <select class="form-control" id="garage_projet" name="garage">
                                        <option value="0">NON</option>
                                        <option value="1">OUI</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <h4 class="form-section animated fadeInDown mb-3 mt-5 border-bottom border-alternate">
                            <i class="fa fa-building"></i>
                            Position
                        </h4>

                        {{--<div class="row justify-content-center mb-4">
                            <div class="col-md-12">
                                <div class="row justify-content-center">
                                    <div class="col-md-2 mb-2 text-center">
                                        <label for="garage_projet">Choix Nord </label>
                                        <select class="form-control" id="choix_nord_projet" name="choix_nord">
                                            <option value="1">Mitoyen</option>
                                            <option value="0">Rue</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 pb-4 pt-4 text-center align-self-center">
                                <label for="garage_projet">Choix Ouest </label>
                                <select class="form-control" id="choix_ouest_projet" name="choix_ouest">
                                    <option value="1">Mitoyen</option>
                                    <option value="0">Rue</option>
                                </select>
                            </div>
                            <div class="col-md-5 border">
                                <div style="height: 200px"></div>
                            </div>
                            <div class="col-md-2 pb-4 pt-4 text-center align-self-center">
                                <label for="garage_projet">Choix Est </label>
                                <select class="form-control" id="choix_est_projet" name="choix_est">
                                    <option value="1">Mitoyen</option>
                                    <option value="0">Rue</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="row justify-content-center">
                                    <div class="col-md-2 mt-2 text-center">
                                        <label for="garage_projet">Choix Sud </label>
                                        <select class="form-control" id="choix_sud_projet" name="choix_sud">
                                            <option value="1">Mitoyen</option>
                                            <option value="0">Rue</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>--}}

                        <div class="row justify-content-center mb-3">
                            <div class="col-md-12">
                                <div class="row justify-content-center">
                                    <div class="col-lg-2  text-center">
                                        <div class="form-group">
                                            <label for="longeur_projet">Longeur(m)</label>
                                            <input type="number" id="longeur_projet" name="longeur" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-2 text-center">
                                        <label for="choix_nord_projet">Choix Nord </label>
                                        <select class="form-control" id="choix_nord_projet" name="choix_nord" ng-click="actionSurPosition()">
                                            <option value="1">Mitoyen</option>
                                            <option value="0">Rue</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 align-self-center">
                                <div class="row ">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="largeur_projet">Largeur(m)</label>
                                            <input type="number" id="largeur_projet" name="largeur" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 pb-4 text-center align-self-center">
                                        <label for="choix_ouest_projet">Choix Ouest </label>
                                        <select class="form-control" id="choix_ouest_projet" name="choix_ouest"  ng-click="actionSurPosition()">
                                            <option value="1">Mitoyen</option>
                                            <option value="0">Rue</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 border">
                                <div style="height: 200px"></div>
                            </div>
                            <div class="col-md-3 align-self-center">
                                <div class="row ">
                                    <div class="col-md-6 pb-4 pt-4 text-center align-self-center">
                                        <label for="choix_est_projet">Choix Est </label>
                                        <select class="form-control" id="choix_est_projet" name="choix_est"  ng-click="actionSurPosition()">
                                            <option value="1">Mitoyen</option>
                                            <option value="0">Rue</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="row justify-content-center">
                                    <div class="col-md-2 mt-2 text-center">
                                        <label for="choix_sud_projet">Choix Sud </label>
                                        <select class="form-control" id="choix_sud_projet" name="choix_sud"  ng-click="actionSurPosition()">
                                            <option value="1">Mitoyen</option>
                                            <option value="0">Rue</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-lg-3">
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="electricte_projet" value="true" name="electricite"> Electricté
                                  </label>
                            </div>
                            <div class="col-lg-3">
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="accesvoirie_projet" value="true" name="acces_voirie"> Accés voirie
                                  </label>
                            </div>
                            <div class="col-lg-3">
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="ass_projet" value="true" name="assainissement"> Assainissement
                                  </label>
                            </div>
                            <div class="col-lg-3">
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="cadastre_projet" value="true" name="geometre"> Cadastre
                                  </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="courant_faible_projet" value="true" name="courant_faible"> Courant Faible
                                  </label>
                            </div>
                            <div class="col-lg-3">
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="eaux_pluviable_projet" value="true" name="eaux_pluviable"> Eaux pliviale
                                  </label>
                            </div>
                            <div class="col-lg-3">
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="bornes_visible_projet" value="true" name="bornes_visible"> Bornez Visible
                                  </label>
                            </div>
                            <div class="col-lg-3">
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="necessite_bornage_projet" value="true" name="necessite_bornage"> Necessite bornage
                                  </label>
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
                                        <!-- <div class="col-lg-3">
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
                                        </div> -->
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="chambre_projet">Chbres simples</label>
                                                <input type="number" name="chambre" id="chambre_projet" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="chambre_sdb_projet">Chbres SDB</label>
                                                <input type="number" name="sdb" id="chambre_sdb_projet" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="bureau_projet">Bureau</label>
                                                <input type="number" id="bureau_projet" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="salon_projet">Salon</label>
                                                <input type="number" name="salon" id="salon_projet" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="cuisine_projet">Cuisine</label>
                                                <input type="number" name="cuisine" id="cuisine_projet" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="toillette_projet">Toillette</label>
                                                <input type="number" name="toillette" class="form-control" id="toillette_projet">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
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
                                <h3> Ajouter un Niveau pour ce projet
                                </h3>
                            </div>
                            <div class="col-md-12" ng-if="produitsInTable.length !=0">
                                <div class="table-responsive">
                                    <table class="table table-responsive-sm table-bordered mb-0 text-center dataTable dtr-inline" id="tabNiveau" role="grid">
                                        <thead>
                                       {{-- <th class="text-center">N°</th>--}}
                                        <th class="text-center">Niveau</th>
                                        <!-- <th class="text-center">Pièce</th> -->
                                        <th class="text-center">Chbres Sple</th>
                                        <th class="text-center">Chbres SDB</th>
                                        <th class="text-center">Bureau</th>
                                        <th class="text-center">Salon</th>
                                        <th class="text-center">Cuisine</th>
                                        <th class="text-center">Toillettes</th>
                                        <th class="text-center">Actions</th>
                                        </thead>
                                        <tbody>
                                        <tr class="animated fadeIn" ng-repeat="item in produitsInTable">
                                         {{--   <td class="text-center">
                                                1
                                            </td>--}}
                                            <td class="text-center">
                                                @{{ item.niveau }}
                                            </td>
                                            <!-- <td class="text-center">
                                                @{{ item.piece }}
                                            </td> -->
                                            <td class="text-center">
                                                @{{ item.chambre }}
                                            </td>
                                            <td class="text-center">
                                                @{{ item.sdb }}
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
                                                @{{ item.toillette }}
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

                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description_proje">Desciption</label>
                                    <textarea rows="4" class="form-control" id="description_projet" name="description"></textarea>
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

    <div class="modal fade" id="modal_addprojet" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-lg" role="document"  style="max-width: 54%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Valider le Projet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body m-3">
                    <form id="form_addpaye_projet" class="form" enctype="multipart/form-data" accept-charset="UTF-8">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="montant_projet">Montant</label>
                                    <input type="number" class="form-control" id="montant_projet" name="montant">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" ng-click="activerProjet()">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>


    <div class="modal fade" id="modal_addpub" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-lg" role="document"  style="max-width: 54%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Publication</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body m-3">
                    <form id="form_addpub" class="form" enctype="multipart/form-data" accept-charset="UTF-8">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="fichier_pub">Image</label>
                                    <input type="file" class="form-control" id="fichier_pub" name="image">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="description_pub">Desciption</label>
                                    <textarea rows="3" class="form-control" id="description_pub" name="description"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" ng-click="addElement($event,'pub')">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>



@endsection

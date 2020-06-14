
<div class="">
    <div class="float-right pt-0">
        <button class="btn btn-primary"  ng-click="viderTab();showModalAdd('demande')" title="ajouter une demande"><i class="fa fa-plus"></i></button>
    </div>
    <h1 class="h3 mb-4 text-gray-800">Liste des projets</h1>

    <!-- Page Heading -->
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->

        <!-- Card Content - Collapse -->
        <div class="collapse show" id="collapseCardExample">
            <div class="card-body">
                <form>
                    <div class="form-row mt-4">
                        <div class="col-md-12 col-sm-12 uk-margin-small-top text-center text-md-center" id="etat">
                            <span class="uk-text-bold fsize-14 uk-text-uppercase uk-margin-small-right">Etat : </span>
                            <input type="radio" value="1" name="radioBtnComposition" ng-click="onRadioCompositionClick($event, '1')" class="uk-radio"> <span class="fsize-12 uk-margin-small-right">en cours</span>
                            <input type="radio" value="2" name="radioBtnComposition" ng-click="onRadioCompositionClick($event, '2')" class="uk-radio"> <span class="fsize-12 uk-margin-small-right">finalisé</span>
                            <input type="radio" checked  name="radioBtnComposition" ng-click="onRadioCompositionClick($event, '')" class="uk-radio true"> <span class="fsize-12 uk-margin-small-right">Tout</span>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control" id="searchoption_projet" ng-model="searchoption_projet" name="searchoption">
                                <option value="">Rechercher dans </option>
                                <option value="nomcomplet">Nom client</option>
                                <option value="telephone">Téléphone</option>
                                <option value="email">E-mail</option>
                                <option value="pays">Pays</option>
                                <option value="adress_complet">Adresse</option>
                                <option value="code_postal">Code postal</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" id="searchtexte_projet" ng-model="searchtexte_projet" placeholder="Texte de la recherche" ng-readonly="!searchoption_projet" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Entre le </label>
                                <input type="date" id="created_at_start_listprojet" name="created_at_start" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Et le </label>
                                <input type="date" id="created_at_end_listprojet" name="created_at_end" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12 text-right">
                            <button class="mt-2 btn btn-primary pull-right" ng-click="pageChanged('projet')">
                                Filtrer <i class="fa fa-search"></i>
                            </button>
                        </div>

                    </div>
                </form>

                <div class="mt-3">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr align="center">
                                <th>Code Projet</th>
                                <th>Date creation</th>
                                <th>A valider dans</th>
                                <th>Nom Complet</th>
                                <th>Adresse</th>

                                <th>N° telephone</th>

                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr align="center" ng-repeat="item in projets">
                                <td>@{{ $index + 1 }}</td>
                                <td>@{{ item.created_at_fr }}</td>
                                <td>
                                    <span ng-if="item.a_valider==0" class="badge badge-danger">Epuisé</span>
                                    <span ng-if="item.a_valider!=0" class="badge badge-success">@{{ item.a_valider }} jour</span>

                                </td>
                                <td>@{{ item.user.name}}</td>
                                <td>@{{item.user.adresse_complet}}</td>

                                 <td>@{{item.user.telephone}}</td>

                                <td class="text-center">
                                    <a href="#!/detail-projet/@{{ item.id }} " class="btn btn-sm btn-primary btn-circle">
                                        <i class="fas fa-info"></i>
                                    </a>
                                    <a  class="btn btn-sm btn-success btn-circle"  href="#!/detail-projet/@{{ item.id }} ">
                                        <i class="fa fa-file-excel" title="generer le fichier excel"></i>
</a>
                                    <a  class="btn btn-sm btn-warning btn-circle"  href="#!/detail-projet/@{{ item.id }} ">
                                        <i class="fa fa-file-pdf" title="generer le pdf"></i>
</a>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>

                </div>


                <!-- PAGINATION -->
                <div class="row mt-10">
                    <div class="col-md-4">
                        <span>Affichage par</span>
                        <select class="form-control-sm" ng-model="paginationentrestock.entryLimit" ng-change="pageChanged('entrestock')">
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="col-md-8 float-right">
                        <nav aria-label="Page navigation">
                            <ul class="uk-pagination float-right" uib-pagination total-items="paginationentrestock.totalItems" ng-model="paginationentrestock.currentPage" max-size="paginationentrestock.maxSize" items-per-page="paginationentrestock.entryLimit" ng-change="pageChanged('entrestock')" previous-text="‹" next-text="›" first-text="«" last-text="»" boundary-link-numbers="true" rotate="false"></ul>
                        </nav>
                    </div>
                </div>
                <!-- /PAGINATION -->
            </div>
        </div>

    </div>

    <br>

</div>

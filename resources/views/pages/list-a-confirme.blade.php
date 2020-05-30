
<div class="">
    <h1 class="h3 mb-4 text-gray-800">Liste des demandes d'inscriptions à confirmées</h1>

    <!-- Page Heading -->
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->

        <!-- Card Content - Collapse -->
        <div class="collapse show" id="collapseCardExample">
            <div class="card-body">
                <form>
                    <div class="form-row mt-4">
                        <div class="col-md-6">
                            <select class="form-control" id="searchoption_client" ng-model="searchoption_client" name="searchoption">
                                <option value="">Rechercher dans </option>
                                <option value="nomcomplet">Nom client</option>
                                <option value="telephone">Téléphone</option>
                                <option value="email">E-mail</option>
                                <option value="code_client">Code client</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" id="searchtexte_client" ng-model="searchtexte_client" placeholder="Texte de la recherche" ng-readonly="!searchoption_client" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-12 text-right">
                            <button class="mt-2 btn btn-primary pull-right" ng-click="pageChanged('client')">
                                Filtrer <i class="fa fa-search"></i>
                            </button>
                        </div>

                    </div>
                </form>

                <div class="mt-3">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Nom Complet</th>
                                <th>Code Postal</th>
                                <th>Telephone</th>
                                <th>Email</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr align="center" ng-repeat="item in users" ng-if="item.active==0">
                               <td>@{{ item.name }}</td>
                               <td>@{{ item.code_postal }}</td>
                               <td>@{{ item.telephone }}</td>
                               <td>@{{ item.email }}</td>
                                <td class="text-center">
                                    <button ng-if="item.active" class="menu-item uk-icon-button fa fa-thumbs-down border-0 back-rednoir text-white" title="Désactiver ce client" ng-click="showModalChangeStatut($event,'user', 0,item, 'Désactiver ce client')"></button>
                                      
                                        <button ng-if="!item.active"  class="btn btn-sm btn-circle btn-success" title="Activer ce client" ng-click="showModalChangeStatut($event,'user', 1,item, 'Activer ce client')"></button>
                                        <button class="btn btn-sm btn-circle btn-danger"   ng-click="deleteElement('restaurant',item.id)"title="Supprimer">
                                        <span class="fa fa-trash"></span>
                                        </button>

                                    
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

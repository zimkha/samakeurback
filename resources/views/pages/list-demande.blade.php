
<div class="">
    <div class="float-right pt-0">
        <button class="btn btn-primary"  data-toggle="modal" data-target="#modalPlan" title="ajouter un nouveau plan"><i class="fa fa-plus"></i></button>
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
                        <div class="col-md-12 text-center">
                            <input  type="radio" id="male" name="gender" value="male">
                            <label for="male">en cours</label>
                            <input type="radio" id="female" name="gender" value="female">
                            <label for="female">finalise</label>
                            <input type="radio" id="other"checked name="gender" value="other">
                            <label for="other" >Tout</label>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control" id="searchoption_client" ng-model="searchoption_client" name="searchoption">
                                <option value="">Rechercher dans </option>
                                <option value="nomcomplet">Nom client</option>
                                <option value="telephone">Téléphone</option>
                                <option value="email">E-mail</option>
                                <option value="email">Pays</option>
                                <option value="email">Adresse</option>
                                <option value="code_client">Code client</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" id="searchtexte_client" ng-model="searchtexte_client" placeholder="Texte de la recherche" ng-readonly="!searchoption_client" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Entre le </label>
                                <input type="date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Et le </label>
                                <input type="date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12 text-right">
                            <button class="mt-2 btn btn-primary pull-right" ng-click="pageChanged('demande')">
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
                                <th>Pays</th>
                                <th>Adresse</th>
                                <th>Code postal</th>
                                <th>N° telephone</th>
                                <th>Email</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Tiger Nixon</td>
                                <td>System Architect</td>
                                <td>Edinburgh</td>
                                <td>61</td>
                                <td>2011/04/25</td>
                                <td>$320,800</td>
                                <td class="text-center">
                                    <a href="#!/detail-demande/2" class="btn btn-sm btn-primary btn-circle">
                                        <i class="fas fa-info"></i>
                                    </a>
                                    <button  class="btn btn-sm btn-success btn-circle">
                                        <i class="fa fa-file-excel" title="generer le fichier excel"></i>
                                    </button>
                                    <button  class="btn btn-sm btn-warning btn-circle">
                                        <i class="fa fa-file-pdf" title="generer le pdf"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Tiger Nixon</td>
                                <td>System Architect</td>
                                <td>Edinburgh</td>
                                <td>61</td>
                                <td>2011/04/25</td>
                                <td>$320,800</td>
                                <td class="text-center">
                                    <a href="#!/detail-demande/2" class="btn btn-sm btn-primary btn-circle">
                                        <i class="fas fa-info"></i>
                                    </a>
                                    <button  class="btn btn-sm btn-success btn-circle">
                                        <i class="fa fa-file-excel" title="generer le fichier excel"></i>
                                    </button>
                                    <button  class="btn btn-sm btn-warning btn-circle">
                                        <i class="fa fa-file-pdf" title="generer le pdf"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Tiger Nixon</td>
                                <td>System Architect</td>
                                <td>Edinburgh</td>
                                <td>61</td>
                                <td>2011/04/25</td>
                                <td>$320,800</td>
                                <td class="text-center">
                                    <a href="#!/detail-demande/2" class="btn btn-sm btn-primary btn-circle">
                                        <i class="fas fa-info"></i>
                                    </a>
                                    <button  class="btn btn-sm btn-success btn-circle">
                                        <i class="fa fa-file-excel" title="generer le fichier excel"></i>
                                    </button>
                                    <button  class="btn btn-sm btn-warning btn-circle">
                                        <i class="fa fa-file-pdf" title="generer le pdf"></i>
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

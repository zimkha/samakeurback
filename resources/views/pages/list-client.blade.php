
<div class="">
    <h1 class="h3 mb-4 text-gray-800">Liste des clients</h1>

    <!-- Page Heading -->
    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->

        <!-- Card Content - Collapse -->
        <div class="collapse show" id="collapseCardExample">
            <div class="card-body">
                <form>
                    <div class="form-row mt-4">
                        <div class="col-md-6">
                            <select class="form-control form-control-sm" id="searchoption_client" ng-model="searchoption_client" name="searchoption">
                                <option value="">Rechercher dans </option>
                                <option value="nomcomplet">Nom client</option>
                                <option value="telephone">Téléphone</option>
                                <option value="email">E-mail</option>
                                <option value="code_client">Code client</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-sm" id="searchtexte_client" ng-model="searchtexte_client" placeholder="Texte de la recherche" ng-readonly="!searchoption_client" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-12 text-right">
                            <button class="mb-2 btn btn-primary pull-right" ng-click="pageChanged('client')">
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
                                <th>Code Postal</th>
                                <th>Telephone</th>
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
                                    <a href="#!/detail-client/1" class="btn btn-sm btn-primary btn-circle">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                    <button class="btn btn-sm btn-circle btn-danger">
                                        <span class="fa fa-trash"></span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Garrett Winters</td>
                                <td>Accountant</td>
                                <td>Tokyo</td>
                                <td>63</td>
                                <td>2011/07/25</td>
                                <td>$170,750</td>
                                <td class="text-center">
                                    <a href="#!/detail-client/1" class="btn btn-sm btn-primary btn-circle">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                    <button class="btn btn-sm btn-circle btn-danger">
                                        <span class="fa fa-trash"></span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Ashton Cox</td>
                                <td>Junior Technical Author</td>
                                <td>San Francisco</td>
                                <td>66</td>
                                <td>2009/01/12</td>
                                <td>$86,000</td>
                                <td class="text-center">
                                    <a href="#!/detail-client/1" class="btn btn-sm btn-primary btn-circle">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                    <button class="btn btn-sm btn-circle btn-danger">
                                        <span class="fa fa-trash"></span>
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>Michelle House</td>
                                <td>Integration Specialist</td>
                                <td>Sidney</td>
                                <td>37</td>
                                <td>2011/06/02</td>
                                <td>$95,400</td>
                                <td class="text-center">
                                    <a href="#!/detail-client/1" class="btn btn-sm btn-primary btn-circle">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                    <button class="btn btn-sm btn-circle btn-danger">
                                        <span class="fa fa-trash"></span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Suki Burks</td>
                                <td>Developer</td>
                                <td>London</td>
                                <td>53</td>
                                <td>2009/10/22</td>
                                <td>$114,500</td>
                                <td class="text-center">
                                    <a href="#!/detail-client/1" class="btn btn-sm btn-primary btn-circle">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                    <button class="btn btn-sm btn-circle btn-danger">
                                        <span class="fa fa-trash"></span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Prescott Bartlett</td>
                                <td>Technical Author</td>
                                <td>London</td>
                                <td>27</td>
                                <td>2011/05/07</td>
                                <td>$145,000</td>
                                <td class="text-center">
                                    <a href="#!/detail-client/1" class="btn btn-sm btn-primary btn-circle">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                    <button class="btn btn-sm btn-circle btn-danger">
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

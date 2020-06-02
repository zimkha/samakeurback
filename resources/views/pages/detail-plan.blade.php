<div class="">

    <!-- Page Heading -->
    <div class="row">

        <div class="col-lg-12">

            <div class="row">
                <div class="col-md-8">
                    Detail Plan: code-plan: <strong><u><span class="badge badge-info">PL0001</span></u></strong>
                </div>
                <div class="col-md-4">
                    <div class="float-right pt-0 mx-1 text-right">
                        <button class="btn btn-success btn-circle mb-2" ng-click="showModalAdd('lier_plan')" title="lier le plan a un projet"><i class="fa fa-magnet"></i></button>
                    </div>
                    <div class="float-right pt-0 mx-1 text-right">
                        <button class="btn btn-warning btn-circle mb-2" ng-click="showModalAdd('jointe_plan')" title="Fichier a un projet"><i class="fa fa-file"></i></button>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" target="_self" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">A propos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" target="_self" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Demandes associés au plan: Encour</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" target="_self" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Demandes asspciés au plan: Finalisés</a>
                        </li>
                    </ul>
                </div>


                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="card">

                            <div class="card-body">

                                <div class="mt-40">

                                    <div class="animated fadeInDown shadow px-1">
                                        <div class="text-center p-1">
                                            <div>
                                                <i class="fa fa-calendar-check"></i> <strong><u>Date creation:</u></strong>
                                                <span class="text-muted">12/04/2020</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div  class="card-body row animated fadeInUp">
                                        <div class=" col-md-3 col-sm-12 mt-10">
                                            <div class="border-danger">
                                                <h6> Superficie :<strong><u></u> aa</u></strong></h6>
                                            </div>

                                        </div>
                                        <div class=" col-md-3 col-sm-12 mt-10">
                                            <div class="border-danger">
                                                <h6> nbr étage :<strong><u></u> aa</u></strong></h6>
                                            </div>

                                        </div>
                                        <div class=" col-md-3 col-sm-12 mt-10">
                                            <div class="border-danger">
                                                <h6> nbr chambre :<strong><u></u> aa</u></strong></h6>
                                            </div>

                                        </div>
                                        <div class=" col-md-3 col-sm-12 mt-10">
                                            <div class="border-danger">
                                                <h6> cuisine :<strong><u></u> aa</u></strong></h6>

                                            </div>

                                        </div>
                                        <div class=" col-md-3 col-sm-12 mt-10">
                                            <div class="border-danger">
                                                <h6> nbr wc :<strong><u></u> aa</u></strong></h6>

                                            </div>

                                        </div>
                                        <div class=" col-md-3 col-sm-12 mt-10">
                                            <div class="border-danger">
                                                <h6> type chambre :<strong><u></u> type 1</u></strong></h6>
                                            </div>
                                        </div>
                                        <div class=" col-md-3 col-sm-12 mt-10">
                                            <div class="border-danger">
                                                <h6> type terrain    :<strong><u></u> type 1</u></strong></h6>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                        <tr align="center">
                                            <th>Code</th>
                                            <th>Date</th>
                                            <th>Client</th>
                                            <th>Adresse </th>
                                            <th>etat</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <tr align="center">
                                            <td>DM0001</td>
                                            <td>12/01/2020</td>
                                            <td>Khazim Ndiaye</td>
                                            <td>Dakr Senegal</td>
                                            <td><span class="badge badge-success">PAYE</span></td>
                                            <td>
                                                <button href="detail-client.html" class="btn btn-primary btn-circle" data-toggle="modal" data-target=".bd-example-modal-lg">
                                                    <i class="fas fa-info-circle"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        <tr align="center">
                                            <td>DM0002</td>
                                            <td>12/0Z/2020</td>
                                            <td>Moussa Ndiaye</td>
                                            <td>Dakr Senegal</td>
                                            <td><span class="badge badge-success">PAYE</span></td>
                                            <td>
                                                <button href="detail-client.html" class="btn btn-primary btn-circle" data-toggle="modal" data-target=".bd-example-modal-lg">
                                                    <i class="fas fa-info-circle"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr align="center">
                                            <td>DM0021</td>
                                            <td>12/03/2020</td>
                                            <td>Sydi Ndiaye</td>
                                            <td>Dakr Senegal</td>
                                            <td><span class="badge badge-danger">NON PAYE</span></td>
                                            <td>
                                                <button href="detail-client.html" class="btn btn-primary btn-circle" data-toggle="modal" data-target=".bd-example-modal-lg">
                                                    <i class="fas fa-info-circle"></i>
                                                </button>
                                            </td>
                                        </tr>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                        <tr align="center">
                                            <th>Code</th>
                                            <th>Date</th>
                                            <th>Client</th>
                                            <th>Adresse </th>
                                            <th>etat</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <tr align="center">
                                            <td>DM0001</td>
                                            <td>12/01/2020</td>
                                            <td>Khazim Ndiaye</td>
                                            <td>Dakr Senegal</td>
                                            <td><span class="badge badge-success">PAYE</span></td>
                                            <td>
                                                <button href="detail-client.html" class="btn btn-primary btn-circle" data-toggle="modal" data-target=".bd-example-modal-lg">
                                                    <i class="fas fa-info-circle"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        <tr align="center">
                                            <td>DM0002</td>
                                            <td>12/0Z/2020</td>
                                            <td>Moussa Ndiaye</td>
                                            <td>Dakr Senegal</td>
                                            <td><span class="badge badge-success">PAYE</span></td>
                                            <td>
                                                <button href="detail-client.html" class="btn btn-primary btn-circle" data-toggle="modal" data-target=".bd-example-modal-lg">
                                                    <i class="fas fa-info-circle"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr align="center">
                                            <td>DM0021</td>
                                            <td>12/03/2020</td>
                                            <td>Sydi Ndiaye</td>
                                            <td>Dakr Senegal</td>
                                            <td><span class="badge badge-danger">NON PAYE</span></td>
                                            <td>
                                                <button href="detail-client.html" class="btn btn-primary btn-circle" data-toggle="modal" data-target=".bd-example-modal-lg">
                                                    <i class="fas fa-info-circle"></i>
                                                </button>
                                            </td>
                                        </tr>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

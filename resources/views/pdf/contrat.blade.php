<!DOCTYPE html>
<html lang="zxx" ng-app="samakeur">
<head>
    <!-- Meta Tag -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name='copyright' content=''>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sama keur</title>
    <link rel="icon" type="image/png" href="images/">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <style>

        .body-1 {
            padding: 20px;
        }
        .titre-1 {
            font-size: 20px;
            text-align: center;

        }

        .display-flex {
            display: inline-flex;
        }

        .display-flex-1 {
            background-color: #F7941D!important;
            width: 20px;
            height: 20px;
            line-height: 20px;
            color: white;
            text-align: center;
            margin-right: 10px;
        }

        .display-flex-1-1 {
            background-color: #999C9F!important;
            width: 30px;
            height: 20px;
            line-height: 20px;
            color: white;
            text-align: center;
            margin-right: 10px;
        }

        .display-flex-2 {
            font-size: 16px;
            font-weight: 600;
            color: #F7941D;
        }
    </style>

</head>
<body class="body-1">

    <div class="titre-1">Contrat SAMAKEUR</div>

    <div class="display-flex">
        <div class="display-flex-1">1</div>
        <div class="display-flex-2">PARTIES CONTRACTANTES</div>
    </div>

    <div style="color: #F7941D;font-size: 16px;margin-top: 30px">Le client</div>

    <div class="row mt-3">
        <div class="col-md-2">
            <div class="display-flex">
                <span class="fa fa-check-square"></span>
                <span>M / Mme</span>
            </div>
        </div>
        <div class="col-md-5">
            <div style="color: #F7941D;font-weight: bold">{{ $client->nom}} -- {{ $client->prenom}}</div>
        </div>
        <div class="col-md-4">
            contractant en leur nom personnel.
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-2">
            <div class="display-flex">
                <span class="fa fa-check-square"></span>
                <span>La société</span>
            </div>
        </div>
        <!-- <div class="col-md-5">
            <div style="color: #F7941D;font-weight: bold">Socite_du_client</div>
        </div> -->
        <!-- <div class="col-md-4">
            n° RCS <span style="color: #F7941D;font-weight: bold">data_du_client</span>
        </div> -->
    </div>

    <div class="font-italic" style="margin: 20px 0px">
        (préciser les prénom, nom et qualité du représentant de la société)
    </div>

    <div class="row mt-3">
        <div class="col-md-2">
            <div class="display-flex">
                <span class="fa fa-check-square"></span>
                <span>Adresse</span>
            </div>
        </div>
        <div class="col-md-10">
            <div style="color: #F7941D;font-weight: bold">{{$client->adresse}}</div>
        </div>
    </div>


    <div class="row mt-3">
        <div class="col-md-2">
            <div class="display-flex">
                <span class="fa fa-check-square"></span>
                <span>Telephone</span>
            </div>
        </div>
        <div class="col-md-5">
            <div style="color: #F7941D;font-weight: bold">{{$client->telephone}}</div>
        </div>
        <div class="col-md-4">
            Portable <span style="color: #F7941D;font-weight: bold">{{$client->telephone}}</span>
        </div>
    </div>


    <div class="row mt-3">
        <div class="col-md-2">
            <div class="display-flex">
                <span class="fa fa-check-square"></span>
                <span>Couriel</span>
            </div>
        </div>
        <div class="col-md-10">
            <div style="color: #F7941D;font-weight: bold">{{$client->email}}</div>
        </div>
    </div>


    <div style="color: #F7941D;font-size: 16px;margin-top: 30px">Samakeur</div>

    <div class="row mt-3">
        <div class="col-md-2">
            <div class="display-flex">
                <span class="fa fa-check-square"></span>
                <span>La societe</span>
            </div>
        </div>
        <div class="col-md-10">
            <div> <span style="color: #F7941D;font-weight: bold">SAMAKEUR, </span> <span>représenté par Moussa DANFAKHA gérant de la société</span></div>
        </div>
    </div>

    <div class="font-italic" style="margin: 20px 0px">
        (préciser les prénom, nom et qualité du représentant de la société)
    </div>

    <div class="row mt-3">
        <div class="col-md-2">
            <div class="display-flex">
                <span class="fa fa-check-square"></span>
                <span>Adresse</span>
            </div>
        </div>
        <!-- <div class="col-md-10">
            <div style="color: #F7941D;font-weight: bold">Socite_du_client</div>
        </div> -->
    </div>


    <div class="row mt-3">
        <div class="col-md-2">
            <div class="display-flex">
                <span class="fa fa-check-square"></span>
                <span>Telephone</span>
            </div>
        </div>
        <div class="col-md-5">
            <div style="color: #F7941D;font-weight: bold">Telephone Moussa</div>
        </div>
        <div class="col-md-4">
            Portable <span style="color: #F7941D;font-weight: bold">Telephone Moussa</span>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-2">
            <div class="display-flex">
                <span class="fa fa-check-square"></span>
                <span>Couriel</span>
            </div>
        </div>
        <div class="col-md-10">
            <div style="color: #F7941D;font-weight: bold">admin@samakeur.sn</div>
        </div>
    </div>

    <div style="margin: 20px 0px">
        Conformément aux dispositions, qui font obligation de recourir à une convention écrite préalable à <br>
        tout engagement professionnel, il est convenu ce qui suit :
    </div>

    <div class="display-flex">
        <div class="display-flex-1">2</div>
        <div class="display-flex-2">DESIGNATION DE L’OPERATION</div>
    </div>

    <div class="row mt-3">
        <div class="col-md-3">
            <div class="display-flex">
                <span class="fa fa-check-square"></span>
                <span>Adresse du terrain : </span>
            </div>
        </div>
        <div class="col-md-9">
            <div style="color: #F7941D;font-weight: bold">{{$projet->adresse_terrain}}</div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-3">
            <div class="display-flex">
                <span class="fa fa-check-square"></span>
                <span>Références cadastrales : </span>
            </div>
        </div>
        <div class="col-md-9">
            <div style="color: #F7941D;font-weight: bold">Refe</div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-3">
            <div class="display-flex">
                <span class="fa fa-check-square"></span>
                <span>Surface foncière du terrain : </span>
            </div>
        </div>
        <div class="col-md-8">
            <div style="color: #F7941D;font-weight: bold">{{$projet->superficie}}</div>
        </div>
    </div>

    <div style="color: #F7941D;font-size: 16px;margin-top: 30px">Samakeur</div>

    <div>les informations </div>

    <div class="mt-3">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable">
                <thead>
                <tr class="text-center" style="background-color: #F7941D;color: #fff">
                    <th>Code Projet</th>
                    <th>Date creation</th>
                    <th>Etat</th>
                    <th>Adresse</th>
                    <th>Superficie</th>
                </tr>
                </thead>
                <tbody>
                <tr class="text-center">
                    <td>{{ $projet->code }}</td>
                    <td>{{ $projet->created_at }}</td>
                    <td>
                            @if($projet->etat == 0)
                             <span>En attente de validation</span>
                            @endif

                           @if($projet->etat == 0)
                                 <span>Validé</span>
                            @endif
                    </td>
                    <td>{{ $projet->adresse_terrain }}</td>
                    <td>{{$projet->superficie}}</td>

                </tr>

                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">
        <div class="table-responsive">
            <table class="table table-responsive-bordered" >
                <tr>
                <td>
                    Etages
                </td>
                <td>nbr Chambre</td>
                <td>nbr Salon</td>
                <td>nbr Bureau</td>
                <td>nbr SDB</td>
                <td>nbr Cuisine</td>
                <td>nbr toillette</td>

                </tr>
               
                    <tr>
                        <td>{{ $tableau[0]["etage"] }}</td>
                        <td>{{ $tableau[0]["chambre"]}}</td>
                        <td>{{ $tableau[0]["salon"]}}</td>
                        <td>{{ $tableau[0]["bureau"]}}</td>
                        <td>{{ $tableau[0]["sdb"]}}</td>
                        <td>{{ $tableau[0]["cuisine"]}}</td>
                        <td>{{ $tableau[0]["toillette"]}}</td>

                    </tr>
               
            </table>
        </div>
    </div>

    <div class="display-flex">
        <div class="display-flex-1">3</div>
        <div class="display-flex-2">CONDITIONS DE REALISATION DE LA MISSION</div>
    </div>

    <div style="margin-top: 30px">Cette mission est établie sur la base des éléments de programmation du client.</div>

    <div style="margin-top: 30px">
        Le client dispose d'une enveloppe financière pour les travaux. <br>
        Il est informé que ce montant est indépendant du montant des honoraires de Samakeur, et que <br>
        d’autres dépenses, dont la liste figure en annexe dans le programme, seront à sa charge. <br>
    </div>

    <div style="color: #F7941D;font-size: 16px;margin-top: 30px">Contenu de la mission</div>

    <div style="margin-top: 30px">
        Samakeur analyse le programme fourni par le client, visite les lieux s’il le juge nécessaire et prend
        connaissance des données juridiques, techniques et financières qui lui sont communiquées par le
        client. Ces données comprennent notamment les titres de propriété, les levés de géomètre et les
        relevés des existants, le cas échéant. Samakeur émet toutes les observations et propositions qui lui
        semblent utiles
    </div>

    <div style="margin-top: 30px">
        Il établit les études préliminaires qui ont pour objet de vérifier la constructibilité de l’opération au
        regard des règles d’urbanisme, de vérifier sa faisabilité, d’établir une esquisse, ou au maximum deux
        esquisses du projet répondant au programme
    </div>

    <div style="margin-top: 30px">
        Le niveau de définition de l’esquisse correspond généralement à des documents graphiques établis à
        l’échelle de 1/100 (1cm/m) ou  1/200 (½ cm/m).
    </div>

    <div style="margin-top: 30px">
        Les documents graphiques sont établis : <br>
        sur support informatique modifiable (3 fois au maximum) par samakeur : Les requêtes du client sont
        à transmettre dans son espace client sous un délai de 15 jours à partir de la date de dépôt du plan
        avec le dernier indice. Il est clairement précisé que l’ajout de pièces correspond à un nouveau
        programme et ne peut en aucun cas être considéré comme une modification.
    </div>

    <div style="color: #F7941D;font-size: 16px;margin-top: 30px">Délai de réalisation de la mission</div>

    <div style="margin-top: 30px">
        <div class="display-flex">
            <div class="display-flex-1-1">20</div>
            <div class="">jours ouvrables à compter de la date de signature du présent contrat</div>
        </div>
    </div>

    <div style="margin-top: 10px">
        <div class="display-flex">
            <div class="display-flex-1-1">5</div>
            <div class="">jours ouvrables à compter de la demande de modification du plan.</div>
        </div>
    </div>

    <div style="margin-top: 30px">
        <div class="display-flex">
            <div class="display-flex-1">4</div>
            <div class="display-flex-2">REMUNERATION </div>
        </div>
    </div>

    <div style="margin-top: 30px">
        Pour la mission qui lui est confiée, samakeur perçoit une rémunération forfaitaire de
        <span style="color: #F7941D;font-size: 16px;margin-top: 30px"> charger la somme rentrée par l’administrateur lors de la validation de la demande </span> . XXXXX Fcfa
    </div>


    <div style="margin-top: 30px">
        <div class="display-flex">
            <div class="display-flex-1">5</div>
            <div class="display-flex-2">RÉALISATION DU PROJET - POURSUITE DE LA MISSION </div>
        </div>
    </div>

    <div style="margin-top: 30px">
        Si le client donne suite au projet établi par Samakeur, un nouveau contrat contractuel est passé entre
        eux pour la poursuite de la mission en suivi de chantier ou réalisation des travaux. Le contenu des
        études préliminaires est alors intégré dans ce nouveau contrat et son coût est déduit du montant
        global des honoraires prévus pour la mission confiée
    </div>

    <div style="margin-top: 30px">
        Dans tous les cas, Samakeur conserve la propriété intellectuelle et artistique de son œuvre,
        conformément aux articles L111-1 et suivants du code de la propriété intellectuelle.
    </div>


</body>
</html>

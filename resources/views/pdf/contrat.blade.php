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
{{--
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/sb-admin-2.min.css') }}">
--}}


    <style>


        .body-1 {
           /* padding: 20px;*/
        }
        .titre-1 {
            font-size: 25px;
            text-align: center;
        }

        .display-flex {
            display: inline-flex;
        }

        .display-flex-1 {
            background-color: #F7941D!important;width: 20px;height: 20px;line-height: 20px;color: white;text-align: center;margin-right: 10px;
        }

        .display-flex-1-1 {
            background-color: #999C9F!important;width: 30px;height: 20px;line-height: 20px;color: white;text-align: center;margin-right: 10px;
        }

        .display-flex-2 {
            font-size: 16px;font-weight: 600;color: #F7941D;
        }

        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            font-size: 15px;
        }

        #customers tr:nth-child(even){background-color: #f2f2f2;}

        #customers tr:hover {background-color: #ddd;}

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            background-color: #F7941D;
            text-align: center;
            color: white;}
    </style>

</head>
<body class="body-1">

    <div class="titre-1">Contrat SAMAKEUR</div>

    <div style="display: inline-flex!important;margin-top: 20px">
        <div style="background-color: #F7941D!important;width: 20px;height: 20px;line-height: 20px;color: white;text-align: center;margin-right: 10px;">1</div>
        <span style="font-size: 16px;font-weight: 600;color: #F7941D;margin-left: 30px">PARTIES CONTRACTANTES</span>
    </div>

    <div style="color: #F7941D;font-size: 16px;margin-top: 30px">Le client</div>

    <div style="margin-top: 10px">
        <div class="">
            <span>M / Mme</span>

            <span style="color: #F7941D;font-weight: bold;margin-left: 30px">{{ $client->prenom}} {{ $client->nom}}</span>

            <span style="margin-left: 20px"> contractant en leur nom personnel.</span>
        </div>
    </div>
    <div style="margin-top: 10px">
        <!-- <div>
            <span>La société</span>

            <span style="color: #F7941D;font-weight: bold;margin-left: 30px">Socite_du_client</span>

            <span style="margin-left: 20px">n° RCS <span style="color: #F7941D;font-weight: bold">data_du_client</span></span>
        </div> -->
    </div>

    <div class="font-italic" style="margin: 20px 0px;font-size: 15px;font-style: italic">
        (préciser les prénom, nom et qualité du représentant de la société)
    </div>

    <div style="margin-top: 10px">
        <span>Adresse</span>

        <span style="color: #F7941D;font-weight: bold;margin-left: 30px">{{$client->adresse}}</span>

        <span style="margin-left: 20px">Telephone</span>

        <span style="color: #F7941D;font-weight: bold;margin-left: 30px">{{$client->telephone}}</span>

        <span style="margin-left: 30px">Couriel</span>

        <span style="color: #F7941D;font-weight: bold;margin-left: 20px">{{$client->email}}</span>
    </div>


    <div style="color: #F7941D;font-size: 20px;margin-top: 30px">Samakeur</div>

    <div style="margin-top: 10px">
        <span>La societe</span>

        <span style="color: #F7941D;font-weight: bold;margin-left: 30px">SAMAKEUR, </span> <span>représenté par Moussa DANFAKHA gérant de la société</span>
    </div>

    <div class="font-italic" style="margin: 20px 0px;font-size: 15px;font-style: italic">
        (préciser les prénom, nom et qualité du représentant de la société)
    </div>

    <div style="margin-top: 10px">
        <span>Adresse</span>

        <span style="color: #F7941D;font-weight: bold;margin-left: 30px">Villa n° 66, Rue HS18 quartier Hersent Thiès (SENEGAL)</span>

        <span style="margin-left: 20px">Telephone</span>

        <!-- <span style="color: #F7941D;font-weight: bold;margin-left: 30px">Telephone </span> -->

      <span style="margin-left: 20px">Portable <span style="color: #F7941D;font-weight: bold">78 179 93 83</span></span>

        <span style="margin-left: 20px">Couriel</span>

        <span style="color: #F7941D;font-weight: bold;margin-left: 30px">admin@samakeur.sn</span>
    </div>

    <div style="margin: 20px 0px">
        Conformément aux dispositions, qui font obligation de recourir à une convention écrite préalable à <br>
        tout engagement professionnel, il est convenu ce qui suit :
    </div>

    <div style="display: inline-flex;margin-top: 20px">
        <div style="background-color: #F7941D!important;width: 20px;height: 20px;line-height: 20px;color: white;text-align: center;margin-right: 10px;">2</div>
        <span style="font-size: 16px;font-weight: 600;color: #F7941D;margin-left: 30px">DESIGNATION DE L’OPERATION</span>
    </div>

    <div style="margin-top: 10px">
        <span>Adresse du terrain : </span>

        <span style="color: #F7941D;font-weight: bold;margin-left: 20px">{{$projet->adresse_terrain}}</span>

        <span style="margin-left: 20px">Références cadastrales : </span>

        <span style="color: #F7941D;font-weight: bold;margin-left: 20px">Refe</span>

        <span style="margin-left: 20px">Surface foncière du terrain : </span>

        <span style="color: #F7941D;font-weight: bold;margin-left: 20px">{{$projet->superficie}}</span>
    </div>

    <div style="color: #F7941D;font-size: 16px;margin-top: 20px">Samakeur</div>

    <div>les informations </div>

    <div style="margin-top: 20px">
        <div class="table-responsive">
            <table class="table table-bordered" id="customers">
                <thead>
                <tr class="text-center" style="background-color: #F7941D;color: #fff">
                    <th>Code Projet</th>
                    <th>Date creation</th>
                    <th>Adresse</th>
                    <th>Superficie</th>
                </tr>
                </thead>
                <tbody>
                <tr class="text-center">
                    <td>{{ $projet->name }}</td>
                    <td>{{ $projet->created_at }}</td>
                    <td>{{ $projet->adresse_terrain }}</td>
                    <td>{{$projet->superficie}}</td>

                </tr>

                </tbody>
            </table>
        </div>
    </div>
    <div style="margin-top: 20px">
        <div class="table-responsive">
            <table class="table table-bordered" id="customers">
                <tr class="text-center" style="background-color: #F7941D;color: #fff">
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

    <div style="display: inline-flex;margin-top: 30px">
        <div style="background-color: #F7941D!important;width: 20px;height: 20px;line-height: 20px;color: white;text-align: center;margin-right: 10px;">3</div>
        <div style="font-size: 16px;font-weight: 600;color: #F7941D;margin-left: 30px">CONDITIONS DE REALISATION DE LA MISSION</div>
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
        Le niveau de définition de l’esquisse correspond généralement à des vues en plan établis à
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
        <div style="display: inline-flex;">
            <div style="background-color: #999C9F!important;width: 30px;height: 20px;line-height: 20px;color: white;text-align: center;margin-right: 10px;">20</div>
            <div class="" style="margin-left: 40px">jours ouvrables à compter de la date de signature du présent contrat</div>
        </div>
    </div>

    <div style="margin-top: 10px">
        <div style="display: inline-flex;">
            <div style="background-color: #999C9F!important;width: 30px;height: 20px;line-height: 20px;color: white;text-align: center;margin-right: 10px;">5</div>
            <div class="" style="margin-left: 40px">jours ouvrables à compter de la demande de modification du plan.</div>
        </div>
    </div>

    <div style="margin-top: 30px">
        <div style="display: inline-flex;">
            <div style="background-color: #F7941D!important;width: 20px;height: 20px;line-height: 20px;color: white;text-align: center;margin-right: 10px;">4</div>
            <div style="font-size: 16px;font-weight: 600;color: #F7941D;margin-left: 30px">REMUNERATION </div>
        </div>
    </div>

    <div style="margin-top: 30px">
        Pour la mission qui lui est confiée, samakeur perçoit une rémunération forfaitaire de
        <span style="color: #F7941D;font-size: 16px;margin-top: 30px"> charger la somme rentrée par l’administrateur lors de la validation de la demande </span> . {{ $projet->montant }} Fcfa
    </div>


    <div style="margin-top: 30px">
        <div style="display: inline-flex;">
            <div style="background-color: #F7941D!important;width: 20px;height: 20px;line-height: 20px;color: white;text-align: center;margin-right: 10px;">5</div>
            <div style="font-size: 16px;font-weight: 600;color: #F7941D;margin-left: 30px">RÉALISATION DU PROJET - POURSUITE DE LA MISSION </div>
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

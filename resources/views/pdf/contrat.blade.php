<!-- <html>
    <head>
        <style>
            #titre{
                font-size: 20px;
                color: blue;
            }
            .para
            {
                color: red;
            }
        </style>
    </head>
    <body>
        <p align="center" class="para" id=titre>CONTRAT SAMAKEUR </p>

<p  class="para"> 1 ) 1 PARTIES CONTRACTANTES</p>
    </body>
   <span style="font-size:12; color:blue"> Le client</span>
    <br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; M / Mmm : Khazim Ndiaye contractant en leur nom personnel <br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Adresse:  Adresse Client <br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Telephone : 77 196 73 00 <br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Courier <br><br>
   <div class="droite">
    <span style="font-size:12; color:blue">Samakeur</span>
    <br><br>
       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; La Société:  Samakeur, Réepreésenté par Moussa DANFAKHA gérant de la société
       <br>
       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Adresse:  Adresse 16 mail albert jacquard 94600 Choisy le roi
       <br>
       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Telephone : +33(0)782133856 <br>
       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Courier: admin@samakeur.sn <br><br>
   </div>
   
   <p>Conformément aux dispositions, qui font obligation de recourir à une convention écrite préalable à
    tout engagement professionnel, il est convenu ce qui suit </p>
   <br>
   <p class="para">2 ) DESIGNATION DE L’OPERATION</p>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Adresse du terrain:  Adresse Client <br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Référence Cadastral:  Texte du référence <br>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Surface foncière du terrain : 200 m2<br>

   <




</html> -->
<html>
<title>CONTRAT</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    /* body {
      padding: 0;
      margin: 0;
      font-family: "Times New Roman", Times, serif;
    } */

    header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      height: 50px;
      padding: 10px 50px;
     
      z-index: 1000;
    }

    /* .text-center {
      text-align: center;
    }

    .phone {
      float: right;
      margin-bottom: 10px;
      margin-right: 150px;
    }

    .phone h4 {
      text-align: center;
      right: 50px;
    } */

    /* main {
      margin-top: 50px;
      padding: 10px 50px;
    }

    .after-header {
      height: 30px;
      padding: 10px 0;
    }

    .patient-id {
      
    }

    .date-day {
      float: right;
    }

    .page-header {
      margin-top: 5px;
      padding: 5px;
      background-color: aqua;
    } */

    /* .page-header h2 {
      font-family: monospace;
      font-size: 20px;
      text-align: center;
    } */

    footer {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      height: 50px;
      border-bottom: 1px solid #1f1f1f;
      border-top: 1px solid #1f1f1f;
      z-index: 1000;
    }

    footer h3 {
      padding-left: 50px;
    }

    .details {
      margin-top: 0;
      padding: 2px 0;
    }

    table {
      margin: 5px 0;
      width: 100%;
      border-top: 1px dotted #1f1f1f;
      border-right: 1px dotted #1f1f1f;
    }

    td {
      text-align: justify;
      padding: 10px;
      border-bottom: 1px dotted #1f1f1f;
      border-left: 1px dotted #1f1f1f;
    }

    table tr>td:first-child {
      border-left: none;
    }

    label {
      font-weight: bold;
      font-size: 15px;
    }
    .my-class{
      border:2px dashed red;
      background-color: lightskyblue;
      color: #000000;
      width: 50;
      height: 30px;;
    }
    .cadre{
      width: 600px;
      height: 20px;
      background-color: lightskyblue;
    }
  </style>
<meta charset="UTF-8"></head>

<body>
  <header>
    <div class="text-center">
      <h1>SAMAKEUR</h1>
  </header>
  <footer>
    <h6>Ce document est la propriété de SAMAKEUR. Il ne peut être reproduit, même partiellement, sans autorisation</h6>
  </footer>
 
      
        <h2 > 1 ) PARTIES CONTRACTANTES</h2>
        <h3 >  Le client</h3>
        <h3 > M / Mme: <label class="my-class">{{ $client->nom}} {{ $client->prenom}}</label> &nbsp;contractant en leur nom personnel</h3>
        @if($client->is_client==0)
        <h3 > Societe <label class="my-class">{{ $client->nom}} {{ $client->prenom}}</label> &nbsp;contractant en leur nom personnel</h3>
        @endif
        <br>
        <h3>Adresse: &nbsp;&nbsp;&nbsp;&nbsp; {{ $client->adresse_complet }}</h3>
        <h3>Telephone: &nbsp;&nbsp;&nbsp;&nbsp; {{ $client->telephone }}</h3>
        <h3>Couriel: &nbsp;&nbsp;&nbsp;&nbsp; {{ $client->email }}</h3>
        <br>
        <h3 >Samakeur</h3>
        <div class="cadre">
          SAMAKEUR,
          représenté par Moussa DANFAKHA gérant de la société
        </div>
        <br>
        <h3>Adresse:  &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;16 mail albert jacquard 94600 Choisy le roi</h3>
        <h3>Tel/portable:&nbsp;&nbsp; +33(0)782133856</h3>
        <h3>Couriel:  &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;samakeuradmine.sn221@gmail.com</h3>
        <p>
          Conformément aux dispositions, qui font obligation de recourir à une convention écrite préalable à
tout engagement professionnel, il est convenu ce qui suit :
        </p>
        <h2 > 2 ) DESIGNATION DE L'OPRATION </h2>
        <h3>Adresse du terrain  &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; {{ $projet->adresse }}</h3>
        <h3>Reference Cadastral  :&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; La référence cadastral</h3>
        <h3>Surface fonciere du terrain: &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; {{ $projet->surface }} m2</h3>
        <br><br><br> <br><br><br> <br><br><br>
        <h3>Description du projet</h3>
        <table>
          <tr>
            <td>Code</td>
            <td>nb pieces</td>
            <td>nb chambres</td>
            <td>nb toillettes</td>
            <td>nb salons</td>
            <td>nb cuisines</td>
            <td>nb SBD</td>
          </tr>
          <tr>
          </tr>
        </table>
        @if($niveaux != null)
        <table>
          <tr>
            <td>Code</td>
            <td>Code</td>
            <td>Code</td>
            <td>Code</td>
          </tr>
        </table>
        @endif



  
</body>

</html>

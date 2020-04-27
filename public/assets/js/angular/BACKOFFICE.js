var app=angular.module('BackEnd',[ 'ngRoute' , 'ngSanitize' , 'ngLoadScript', 'ui.bootstrap' , 'angular.filter']);

var BASE_URL='//'+location.host+'/samakeurback/public';
var imgupload = BASE_URL + '/assets/images/upload.jpg';
var msg_erreur = 'Veuillez contacter le support technique';

app.filter('range', function()
{
    return function(input, total)
    {
        total = parseInt(total);
        for (var i=0; i<total; i++)
            input.push(i);
        return input;
    };
});

// Pour mettre les espaces sur les montants
app.filter('convertMontant', [
    function() { // should be altered to suit your needs
        return function(input) {
            input = input + "";
            return input.replace(/,/g," ");
        };
    }]);


app.filter('changeDatePart', [
    function () { // should be altered to suit your needs
        return function (input) {
            input = input + "";

            var find = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            var replace = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];

            return input.replaceArray(find, replace);

        };
    }]);

$("#formulaire").submit(function(e){
   var form = $(this);
   var url = form.attr('action');
    $.ajax({
        url: BASE_URL+ 'medoc/test/',
        method: "POST",
        data:{
        date_donne:date_donne,
        },
        success: function(data)
        {
            console.log(data);
        }, error: function (data ) {
            console.log(data)
        }
    });
});
app.factory('Init',function ($http, $q)
{
    var factory=
        {
            data:false,
            getElement:function (element,listeattributs, is_graphQL=true, dataget=null)
            {
                var deferred=$q.defer();
                console.log(dataget);
                $http({
                    method: 'GET',
                    url: BASE_URL + (is_graphQL ? '/graphql?query= {'+element+' {'+listeattributs+'} }' : element),
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    data:dataget
                }).then(function successCallback(response)
                {
                    /*lorsque la requete contient des paramètres, il faut decouper pour recupérer le tableau*/
                    if (is_graphQL)
                    {
                        factory.data = response['data']['data'][!element.indexOf('(')!=-1 ? element.split('(')[0] : element];
                    }
                    else
                    {
                        factory.data = response['data'];
                    }
                    deferred.resolve(factory.data);
                }, function errorCallback(error) {
                    console.log('erreur serveur', error);
                    deferred.reject(msg_erreur);
                });
                return deferred.promise;
            },
            getElementPaginated:function (element,listeattributs)
            {
                var deferred=$q.defer();
                $http({
                    method: 'GET',
                    url: BASE_URL + '/graphql?query= {'+element+'{metadata{total,per_page,current_page,last_page},data{'+listeattributs+'}}}'
                }).then(function successCallback(response) {
                    factory.data=response['data']['data'][!element.indexOf('(')!=-1 ? element.split('(')[0] : element];
                    deferred.resolve(factory.data);
                }, function errorCallback(error) {
                    console.log('erreur serveur', error);
                    deferred.reject(msg_erreur);
                });
                return deferred.promise;
            },
           /* getNotifs:function ()
            {
                var deferred=$q.defer();
                $http({
                    method: 'GET',
                    url: BASE_URL + '/medicament/suggestion'
                }).then(function successCallback(response) {
                    factory.data=response['data'];
                    deferred.resolve(factory.data);
                    console.log("Les sugestions",response['data']);
                }, function errorCallback(error) {
                    console.log('erreur serveur', error);
                    deferred.reject(msg_erreur);
                });
                return deferred.promise;
            },*/
            // getEtatStock : function()
            // {
            //     var deferred=$q.defer();
            //     $http({
            //         method: 'POST',
            //         url: BASE_URL + 'medoc/test/',
            //         headers: {
            //             'Content-Type': 'application/json'
            //         },
            //         data:data
            //     }).then(function successCallback(response) {
            //         factory.data=response['data'];
            //         deferred.resolve(factory.data);
            //     }, function errorCallback(error) {
            //         console.log('erreur serveur', error);
            //         deferred.reject(msg_erreur);
            //     });
            //     return deferred.promise;
            // },
            saveElement:function (element,data) {
                var deferred=$q.defer();
                $http({
                    method: 'POST',
                    url: BASE_URL + '/'+element,
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    data:data
                }).then(function successCallback(response) {
                    factory.data=response['data'];
                    deferred.resolve(factory.data);
                }, function errorCallback(error) {
                    console.log('erreur serveur', error);
                    deferred.reject(msg_erreur);
                });
                return deferred.promise;
            },
            changeStatut:function (element,data) {
                var deferred=$q.defer();
                $http({
                    method: 'POST',
                    url: BASE_URL + '/' + element+'/statut',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    data:data
                }).then(function successCallback(response) {
                    factory.data=response['data'];
                    deferred.resolve(factory.data);
                }, function errorCallback(error) {
                    console.log('erreur serveur', error);
                    deferred.reject(msg_erreur);
                });
                return deferred.promise;
            },
            // facturerVente:function (data) {
            //     var deferred=$q.defer();
            //     $.ajax
            //     (
            //         {
            //             url: BASE_URL + '/vente/facture',
            //             type:'POST',
            //             contentType:false,
            //             processData:false,
            //             DataType:'text',
            //             data:data,
            //             headers: {
            //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            //             },
            //             beforeSend: function()
            //             {
            //                 $('#modal_addfactureGeneree').blockUI_start();
            //             },success:function(response)
            //             {
            //                 $('#modal_addfactureGeneree').blockUI_stop();
            //                 factory.data=response;
            //                 deferred.resolve(factory.data);
            //             },
            //             error:function (error)
            //             {
            //                 $('#modal_addfactureGeneree').blockUI_stop();
            //                 console.log('erreur serveur', error);
            //                 deferred.reject(msg_erreur);
            //             }
            //         }
            //     );
            //     //console.log(deferred.promise);
            //     return deferred.promise;
            // },
            importerExcel:function (element,data) {
                var deferred=$q.defer();
                $.ajax
                (
                    {
                        url: BASE_URL + '/' + element+'/import',
                        type:'POST',
                        contentType:false,
                        processData:false,
                        DataType:'text',
                        data:data,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        beforeSend: function()
                        {
                            $('#modal_addliste'+element).blockUI_start();
                        },success:function(response)
                        {
                            $('#modal_addliste'+element).blockUI_stop();
                            factory.data=response;
                            deferred.resolve(factory.data);
                        },
                        error:function (error)
                        {
                            $('#modal_addliste'+element).blockUI_stop();
                            console.log('erreur serveur', error);
                            deferred.reject(msg_erreur);
                        }
                    }
                );
                return deferred.promise;
            },
            // fusionner:function (element,data) {
            //     var deferred=$q.defer();
            //     $.ajax
            //     (
            //         {
            //             url: BASE_URL + '/' + element+'/fusionner',
            //             type:'POST',
            //             contentType:false,
            //             processData:false,
            //             DataType:'text',
            //             data:data,
            //             headers: {
            //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            //             },
            //             beforeSend: function()
            //             {
            //                 $('#modal_addfusion'+element).blockUI_start();
            //             },success:function(response)
            //             {
            //                 $('#modal_addfusion'+element).blockUI_stop();
            //                 factory.data=response;
            //                 deferred.resolve(factory.data);
            //             },
            //             error:function (error)
            //             {
            //                 $('#modal_addfusion'+element).blockUI_stop();
            //                 console.log('erreur serveur', error);
            //                 deferred.reject(msg_erreur);
            //             }
            //         }
            //     );
            //     return deferred.promise;
            // },
            addDetail:function (element,data) {
                var deferred=$q.defer();
                $.ajax
                (
                    {
                        url: BASE_URL + '/' + element,
                        type:'POST',
                        contentType:false,
                        processData:false,
                        DataType:'text',
                        data:data,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        beforeSend: function()
                        {
                            $('#modal_adddetailler'+element).blockUI_start();
                        },success:function(response)
                        {
                            $('#modal_adddetailler'+element).blockUI_stop();
                            factory.data=response;
                            deferred.resolve(factory.data);
                        },
                        error:function (error)
                        {
                            $('#modal_adddetailler'+element).blockUI_stop();
                            console.log('erreur serveur', error);
                            deferred.reject(msg_erreur);
                        }
                    }
                );
                return deferred.promise;
            },
            saveElementAjax:function (element,data) {
                var deferred=$q.defer();
                $.ajax
                (
                    {
                        url: BASE_URL + element,
                        type:'POST',
                        contentType:false,
                        processData:false,
                        DataType:'text',
                        data:data,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        beforeSend: function()
                        {
                            $('#modal_add'+element).blockUI_start();
                        },success:function(response)
                        {
                            $('#modal_add'+element).blockUI_stop();
                            factory.data=response;
                            deferred.resolve(factory.data);
                        },
                        error:function (error)
                        {
                            $('#modal_add' + element).blockUI_stop();
                            console.log('erreur serveur', error);
                            deferred.reject(msg_erreur);

                        }
                    }
                );
                return deferred.promise;
            },
            removeElement:function (element,id) {
                var deferred=$q.defer();
                $http({
                    method: 'DELETE',
                    url: BASE_URL + '/' + element + '/' + id,
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }).then(function successCallback(response) {
                    factory.data=response['data'];
                    deferred.resolve(factory.data);
                }, function errorCallback(error) {
                    console.log('erreur serveur', error);
                    deferred.reject(msg_erreur);
                });
                return deferred.promise;
            },

            // getStatElement:function (element,id) {
            //     $(function() {
            //         $.ajax({
            //             url: BASE_URL + '/' + element + '/statistiques/' + id,
            //             method: "GET",
            //             success : function (data) {
            //                 console.log(data, 'je suis la');
            //                 var mois = [];
            //                 var montant = [];
            //                 for (var i in data )
            //                 {
            //                     if (data[i].montant !=null)
            //                     {
            //                         console.log( data[i].mois);
            //                         mois.push('' + data[i].mois);
            //                         montant.push(data[i].montant);
            //                     }
            //                 }
            //                 var chardata = {
            //                     labels: mois,
            //                     datasets : [
            //                         {
            //                             label: 'Statistiques Pour: ' + element,
            //                             backgroundColor: [
            //                                 'rgba(255, 99, 132, 0.2)',
            //                                 'rgba(54, 162, 235, 0.2)',
            //                                 'rgba(255, 206, 86, 0.2)',
            //                                 'rgba(75, 192, 192, 0.2)',
            //                                 'rgba(153, 102, 255, 0.2)',
            //                                 'rgba(255, 159, 64, 0.2)',
            //                                 'rgba(153, 102, 255, 0.2)',
            //                                 'rgba(153, 152, 255, 0.2)',
            //                                 'rgba(255, 139, 64, 0.2)',
            //                                 'rgba(153, 152, 255, 0.75)',
            //                                 'rgba(255, 159, 44, 0.75)',
            //                                 'rgba(54, 162, 235, 0.2)',],
            //                             borderColor: [
            //                                 'rgba(255, 99, 132, 1)',
            //                                 'rgba(54, 162, 235, 1)',
            //                                 'rgba(255, 206, 86, 1)',
            //                                 'rgba(75, 192, 192, 1)',
            //                                 'rgba(153, 102, 255, 1)',
            //                                 'rgba(255, 159, 64, 1)',
            //                                 'rgba(255, 99, 13, 1)',
            //                                 'rgba(54, 100, 25, 1)',
            //                                 'rgba(255, 26, 86, 1)',
            //                             ],
            //                             borderWidth: 4,
            //                             barPercentage: 1.,
            //                             categoryPercentage:1.,
            //                             barThickness: 6,
            //                             hoverBackgroundColor: 'rgba(200,200,200,1)',
            //                             hoverBorderColor: 'rgba(200,200,200,1)',
            //                             borderSkipped: 'left',

            //                             data: montant
            //                         }
            //                     ]
            //                 };
            //                 //var ctx  = $('#stats'+element);
            //                 this.chart = new Chart('stats'+element, {
            //                     type: 'bar',
            //                     data : chardata,
            //                     options: {
            //                         legend: {
            //                             display: true,
            //                             labels: {
            //                                 fontColor: 'rgb(255, 50, 100)',
            //                                 fontFamily: 'Helvetica Neue',
            //                                 padding: 10,
            //                             }
            //                         },
            //                         tooltips: {
            //                             callbacks: {
            //                                 label: function(tooltipItem, data) {
            //                                     var label = 'Montant';

            //                                     if (label) {
            //                                         label += ': ';
            //                                     }
            //                                     label += Math.round(tooltipItem.yLabel * 100) / 100;
            //                                     return label;
            //                                 },
            //                                 labelColor: function(tooltipItem, chart) {
            //                                     return {
            //                                         borderColor: 'rgb(255, 0, 0)',
            //                                         backgroundColor: 'rgb(255, 0, 0)'
            //                                     };
            //                                 },
            //                                 labelTextColor: function(tooltipItem, chart) {
            //                                     return '#ffffff';
            //                                 }
            //                             }
            //                         }

            //                     }
            //                 });
            //             }, error: function (data) {
            //                 console.log(data)
            //             }

            //         });
            //     });

            // },

            // getStatCaisse:function () {
            //     $.ajax({
            //         url: BASE_URL + 'caisse/mensuelle',
            //         method: "GET",
            //         success: function (data) {
            //             console.log(data);
            //             var caisse = [];
            //             var somme = [];

            //             for (var i in data) {
            //                 if (data[i].somme != null) {
            //                     caisse.push('' + data[i].caisse);
            //                     somme.push(data[i].somme);
            //                 }
            //             }
            //             var chardata = {
            //                 labels: caisse,
            //                 datasets: [
            //                     {
            //                         label: 'Statistiques générales des caisses du mois en cours ',
            //                         backgroundColor: ['#f7464a', '#46bfbd', '#fdb45c', '#985f0d'],
            //                         borderColor: 'rgba(200,200,200,0.75)',
            //                         borderWidth: 4,
            //                         barPercentage: 1.,
            //                         categoryPercentage:1.,
            //                         barThickness: 6,
            //                         hoverBackgroundColor: 'rgba(200,200,200,1)',
            //                         hoverBorderColor: 'rgba(200,200,200,1)',
            //                         data: somme
            //                     }
            //                 ]
            //             };
            //             var canvas = document.getElementById("caisseMensuelle");
            //             var ctx = canvas.getContext("2d");
            //             this.chart = new Chart(ctx, {
            //                 type: 'bar',
            //                 data: chardata,
            //                 options: {
            //                     legend: {
            //                         display: true,
            //                         labels: {
            //                             fontColor: 'rgb(255, 50, 100)',
            //                             fontFamily: 'Helvetica Neue',
            //                             padding: 10,
            //                         }
            //                     },
            //                     tooltips: {
            //                         callbacks: {
            //                             label: function(tooltipItem, data) {
            //                                 var label = 'Montant';

            //                                 if (label) {
            //                                     label += ': ';
            //                                 }
            //                                 label += Math.round(tooltipItem.yLabel * 100) / 100;
            //                                 return label;
            //                             },
            //                             labelColor: function(tooltipItem, chart) {
            //                                 return {
            //                                     borderColor: 'rgb(255, 0, 0)',
            //                                     backgroundColor: 'rgb(255, 0, 0)'
            //                                 };
            //                             },
            //                             labelTextColor: function(tooltipItem, chart) {
            //                                 return '#ffffff';
            //                             }
            //                         }
            //                     }

            //                 }
            //             });
            //         }, error: function (data) {
            //             console.log(data)
            //         }
            //     });

            // },

            // getStatFournisseur:function () {
            //     $.ajax({
            //         url: BASE_URL + 'fournisseur/mensuelle',
            //         method: "GET",
            //         success: function (data) {
            //             console.log(data);
            //             var fournisseur = [];
            //             var somme = [];

            //             for (var i in data) {
            //                 if (data[i].somme != null) {
            //                     fournisseur.push('' + data[i].fournisseur);
            //                     somme.push(data[i].somme);
            //                 }
            //             }
            //             var chardata = {
            //                 labels: fournisseur,
            //                 datasets: [
            //                     {
            //                         label: 'Commandes par fournisseur du mois en cours ',
            //                         backgroundColor: [
            //                             'rgba(255, 99, 132, 0.2)',
            //                             'rgba(54, 162, 235, 0.2)',
            //                             'rgba(255, 206, 86, 0.2)',
            //                             'rgba(75, 192, 192, 0.2)',
            //                             'rgba(153, 102, 255, 0.2)',
            //                             'rgba(255, 159, 64, 0.2)'],
            //                         borderColor: [
            //                             'rgba(255, 99, 132, 1)',
            //                             'rgba(54, 162, 235, 1)',
            //                             'rgba(255, 206, 86, 1)',
            //                             'rgba(75, 192, 192, 1)',
            //                             'rgba(153, 102, 255, 1)',
            //                             'rgba(255, 159, 64, 1)'
            //                         ],
            //                         borderWidth: 1,
            //                         hoverBackgroundColor: 'rgba(200,200,200,1)',
            //                         hoverBorderColor: 'rgba(200,200,200,1)',
            //                         data: somme
            //                     }
            //                 ]
            //             };
            //             var canvas = document.getElementById("fournisseurMensuelle");
            //             var ctx = canvas.getContext("2d");
            //             this.chart = new Chart(ctx, {
            //                 type: 'bar',
            //                 data: chardata,
            //                 options: {
            //                     legend: {
            //                         display: true,
            //                         labels: {
            //                             fontColor: 'rgb(255, 99, 132)',
            //                             fontFamily: 'Helvetica Neue',
            //                             padding: 10,
            //                         }
            //                     },
            //                     tooltips: {
            //                         callbacks: {
            //                             label: function(tooltipItem, data) {
            //                                 var label = 'Montant';

            //                                 if (label) {
            //                                     label += ': ';
            //                                 }
            //                                 label += Math.round(tooltipItem.yLabel * 100) / 100;
            //                                 return label;
            //                             },
            //                             labelColor: function(tooltipItem, chart) {
            //                                 return {
            //                                     borderColor: 'rgb(255, 0, 0)',
            //                                     backgroundColor: 'rgb(255, 0, 0)'
            //                                 };
            //                             },
            //                             labelTextColor: function(tooltipItem, chart) {
            //                                 return '#ffffff';
            //                             }
            //                         }
            //                     }

            //                 }
            //             });
            //         }, error: function (data) {
            //             console.log(data)
            //         }
            //     });

            // },

            // getStatAssurance:function () {
            //     $.ajax({
            //         url: BASE_URL + 'assurance/mensuelle',
            //         method: "GET",
            //         success: function (data) {
            //             console.log(data);
            //             var assurance = [];
            //             var somme = [];

            //             for (var i in data) {
            //                 if (data[i].somme != null) {
            //                     assurance.push('' + data[i].assurance);
            //                     somme.push(data[i].somme);
            //                 }
            //             }
            //             var chardata = {
            //                 labels: assurance,
            //                 datasets: [
            //                     {
            //                         label: 'Top assurances du mois ',
            //                         backgroundColor: [
            //                             'rgba(153, 102, 255, 0.2)',
            //                             'rgba(255, 99, 132, 0.2)',
            //                             'rgba(54, 162, 235, 0.2)',
            //                             'rgba(255, 206, 86, 0.2)',
            //                             'rgba(75, 192, 192, 0.2)',
            //                             'rgba(255, 159, 64, 0.2)'],
            //                         borderColor: [
            //                             'rgba(255, 99, 132, 1)',
            //                             'rgba(54, 162, 235, 1)',
            //                             'rgba(255, 206, 86, 1)',
            //                             'rgba(75, 192, 192, 1)',
            //                             'rgba(153, 102, 255, 1)',
            //                             'rgba(255, 159, 64, 1)'
            //                         ],
            //                         borderWidth: 1,
            //                         hoverBackgroundColor: 'rgba(200,200,200,1)',
            //                         hoverBorderColor: 'rgba(200,200,200,1)',
            //                         data: somme
            //                     }
            //                 ]
            //             };
            //             var canvas = document.getElementById("assuranceMensuelle");
            //             var ctx = canvas.getContext("2d");
            //             this.chart = new Chart(ctx, {
            //                 type: 'bar',
            //                 data: chardata,
            //                 options: {
            //                     legend: {
            //                         display: true,
            //                         labels: {
            //                             fontColor: 'blue',
            //                             fontFamily: 'Helvetica Neue',
            //                             padding: 10,
            //                         }
            //                     },
            //                     tooltips: {
            //                         callbacks: {
            //                             label: function(tooltipItem, data) {
            //                                 var label = 'Montant';

            //                                 if (label) {
            //                                     label += ': ';
            //                                 }
            //                                 label += Math.round(tooltipItem.yLabel * 100) / 100;
            //                                 return label;
            //                             },
            //                             labelColor: function(tooltipItem, chart) {
            //                                 return {
            //                                     borderColor: 'rgb(255, 0, 0)',
            //                                     backgroundColor: 'rgb(255, 0, 0)'
            //                                 };
            //                             },
            //                             labelTextColor: function(tooltipItem, chart) {
            //                                 return '#ffffff';
            //                             }
            //                         }
            //                     }

            //                 }
            //             });
            //         }, error: function (data) {
            //             console.log(data)
            //         }
            //     });

            // },

            // getStatClient:function () {
            //     $.ajax({
            //         url: BASE_URL + 'client/mensuelle',
            //         method: "GET",
            //         success: function (data) {
            //             console.log(data);
            //             var client = [];
            //             var somme = [];

            //             for (var i in data) {
            //                 if (data[i].somme != null) {
            //                     client.push('' + data[i].client);
            //                     somme.push(data[i].somme);
            //                 }
            //             }
            //             var chardata = {
            //                 labels: client,
            //                 datasets: [
            //                     {
            //                         label: 'Top clients du mois ',
            //                         backgroundColor: [
            //                             'rgba(153, 102, 255, 0.2)',
            //                             'rgba(255, 206, 86, 0.2)',
            //                             'rgba(75, 192, 192, 0.2)',
            //                             'rgba(255, 99, 132, 0.2)',
            //                             'rgba(54, 162, 235, 0.2)',
            //                             'rgba(255, 159, 64, 0.2)'],
            //                         borderColor: [
            //                             'rgba(255, 99, 132, 1)',
            //                             'rgba(54, 162, 235, 1)',
            //                             'rgba(255, 206, 86, 1)',
            //                             'rgba(75, 192, 192, 1)',
            //                             'rgba(153, 102, 255, 1)',
            //                             'rgba(255, 159, 64, 1)'
            //                         ],
            //                         borderWidth: 1,
            //                         hoverBackgroundColor: 'rgba(200,200,200,1)',
            //                         hoverBorderColor: 'rgba(200,200,200,1)',
            //                         data: somme
            //                     }
            //                 ]
            //             };
            //             var canvas = document.getElementById("clientMensuelle");
            //             var ctx = canvas.getContext("2d");
            //             this.chart = new Chart(ctx, {
            //                 type: 'bar',
            //                 data: chardata,
            //                 options: {
            //                     legend: {
            //                         display: true,
            //                         labels: {
            //                             fontColor: 'blue',
            //                             fontFamily: 'Helvetica Neue',
            //                             padding: 10,
            //                         }
            //                     },
            //                     tooltips: {
            //                         callbacks: {
            //                             label: function(tooltipItem, data) {
            //                                 var label = 'Montant';

            //                                 if (label) {
            //                                     label += ': ';
            //                                 }
            //                                 label += Math.round(tooltipItem.yLabel * 100) / 100;
            //                                 return label;
            //                             },
            //                             labelColor: function(tooltipItem, chart) {
            //                                 return {
            //                                     borderColor: 'rgb(255, 0, 0)',
            //                                     backgroundColor: 'rgb(255, 0, 0)'
            //                                 };
            //                             },
            //                             labelTextColor: function(tooltipItem, chart) {
            //                                 return '#ffffff';
            //                             }
            //                         }
            //                     }

            //                 }
            //             });
            //         }, error: function (data) {
            //             console.log(data)
            //         }
            //     });

            // },

            // getStatsVenteWeek:function()
            // {
            //     $.ajax({
            //         url: BASE_URL  + 'ventes/statistique/week',
            //         method: "GET",
            //         success: function (data) {
            //             console.log(data, 'donnees de la semaine');
            //             var jour = [];
            //             var montant = [];


            //             for (var i in data) {
            //                 if (data[i].montant != null) {
            //                     jour.push('' + data[i].day);
            //                     montant.push(data[i].montant);

            //                 }
            //             }
            //             var chardata = {
            //                 labels: jour,
            //                 datasets: [
            //                     {
            //                         label: 'Statistiques sur le nombre des ventes par Semaine ',
            //                         backgroundColor: [
            //                             'rgba(255, 99, 132, 0.2)',
            //                             'rgba(54, 162, 235, 0.2)',
            //                             'rgba(255, 206, 86, 0.2)',
            //                             'rgba(75, 192, 192, 0.2)',
            //                             'rgba(153, 102, 255, 0.2)',
            //                             'rgba(255, 159, 64, 0.2)'],
            //                         borderColor: [
            //                             'rgba(255, 99, 132, 1)',
            //                             'rgba(54, 162, 235, 1)',
            //                             'rgba(255, 206, 86, 1)',
            //                             'rgba(75, 192, 192, 1)',
            //                             'rgba(153, 102, 255, 1)',
            //                             'rgba(255, 159, 64, 1)'
            //                         ],
            //                         borderWidth: 1,
            //                         hoverBackgroundColor: 'rgba(200,200,200,1)',
            //                         hoverBorderColor: 'rgba(200,200,200,1)',
            //                         data: montant
            //                     }
            //                 ]
            //             };
            //             var ctx1 = $("#venteWeek");
            //             var barGraph1 = new Chart(ctx1, {
            //                 type: 'bar',
            //                 data: chardata,
            //                 options: {
            //                     legend: {
            //                         display: true,
            //                         labels: {
            //                             fontColor: 'rgb(255, 99, 132)',
            //                             fontFamily: 'Helvetica Neue',
            //                             padding: 10,
            //                         }
            //                     },
            //                     tooltips: {
            //                         callbacks: {
            //                             label: function(tooltipItem, data) {
            //                                 var label = 'Montant';

            //                                 if (label) {
            //                                     label += ': ';
            //                                 }
            //                                 label += Math.round(tooltipItem.yLabel * 100) / 100;
            //                                 return label;
            //                             },
            //                             labelColor: function(tooltipItem, chart) {
            //                                 return {
            //                                     borderColor: 'rgb(255, 0, 0)',
            //                                     backgroundColor: 'rgb(255, 0, 0)'
            //                                 };
            //                             },
            //                             labelTextColor: function(tooltipItem, chart) {
            //                                 return '#ffffff';
            //                             }
            //                         }
            //                     }

            //                 }
            //             });
            //         }, error: function (data) {
            //             console.log(data)
            //         }
            //     });
            // },
            // nbrFournisseur: function()
            // {
            //     $.ajax({
            //         url: BASE_URL+ 'getFournisseur/nbr',
            //         method: "GET",
            //         success: function(data)
            //         {
            //             console.log("bbbdjdjdjjd",data)
            //             $('#nbrFournisseur').text(parseInt(data));
            //         }, error: function (data ) {
            //             console.log(data)
            //         }
            //     });
            // },
            // nbrAssurance: function()
            // {
            //     $.ajax({
            //         url: BASE_URL+ 'getAssurance/nbr',
            //         method: "GET",
            //         success: function(data)
            //         {
            //             $('#nbrAssurance').text(parseInt(data) );
            //         }, error: function (data ) {
            //             console.log(data)
            //         }
            //     });
            // },
            // nbrEntreprise: function()
            // {
            //     $.ajax({
            //         url: BASE_URL+ 'entreprise/nbr',
            //         method: "GET",
            //         success: function(data)
            //         {
            //             $('#nbrEntreprise').text(parseInt(data) );
            //         }, error: function (data ) {
            //             console.log(data)
            //         }
            //     });
            // },
            // nbrParticulier: function()
            // {
            //     $.ajax({
            //         url: BASE_URL+ 'particulier/nbr',
            //         method: "GET",
            //         success: function(data)
            //         {
            //             $('#nbrParticulier').text(parseInt(data));
            //         }, error: function (data ) {
            //             console.log(data)
            //         }
            //     });
            // },
            // journalCaisseDate:function(data)
            // {
            //     $.ajax(
            //         {
            //             url: BASE_URL +'/journal-caisse',
            //             type: 'POST',
            //             contentType:false,
            //             processData:false,

            //             data:data,
            //             headers: {
            //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            //             },
            //             beforeSend: function()
            //             {
            //                 $('#modal_journalcaisse').blockUI_start();
            //             },success:function(response)
            //             {
            //                 $('#modal_journalcaisse').blockUI_stop();
            //                 factory.data=response;
            //               //deferred.resolve(factory.data);
            //             },
            //             error:function (error)
            //             {
            //                 $('#modal_journalcaisse').blockUI_stop();
            //                 console.log('erreur serveur', error);
            //                 deferred.reject(msg_erreur);
            //             }
            //         }
            //     )
            // },
            // getNombreVenteStatsWeek:function()
            // {
            //     $.ajax({
            //         url: BASE_URL  + 'ventes-nombre/statistique/week',
            //         method: "GET",
            //         success: function (data) {
            //             console.log(data, 'donnees de la semaine');
            //             var jour = [];
            //             var montant = [];


            //             for (var i in data) {
            //                 if (data[i].montant != null) {
            //                     jour.push('' + data[i].day);
            //                     montant.push(data[i].montant);

            //                 }
            //             }
            //             var chardata = {
            //                 labels: jour,
            //                 datasets: [
            //                     {
            //                         label: 'Nombre des ventes par Semaine ',
            //                         backgroundColor: [
            //                             'rgba(255, 99, 132, 0.2)',
            //                             'rgba(54, 162, 235, 0.2)',
            //                             'rgba(255, 206, 86, 0.2)',
            //                             'rgba(75, 192, 192, 0.2)',
            //                             'rgba(153, 102, 255, 0.2)',
            //                             'rgba(255, 159, 64, 0.2)'],
            //                         borderColor: [
            //                             'rgba(255, 99, 132, 1)',
            //                             'rgba(54, 162, 235, 1)',
            //                             'rgba(255, 206, 86, 1)',
            //                             'rgba(75, 192, 192, 1)',
            //                             'rgba(153, 102, 255, 1)',
            //                             'rgba(255, 159, 64, 1)'
            //                         ],
            //                         borderWidth: 1,
            //                         hoverBackgroundColor: 'rgba(200,200,200,1)',
            //                         hoverBorderColor: 'rgba(200,200,200,1)',
            //                         data: montant
            //                     }
            //                 ]
            //             };
            //             var ctx1 = $("#venteNbrWeek");
            //             var barGraph1 = new Chart(ctx1, {
            //                 type: 'bar',
            //                 data: chardata,
            //                 options: {
            //                     legend: {
            //                         display: true,
            //                         labels: {
            //                             fontColor: 'rgb(255, 99, 132)',
            //                             fontFamily: 'Helvetica Neue',
            //                             padding: 10,
            //                         }
            //                     },
            //                     tooltips: {
            //                         callbacks: {
            //                             label: function(tooltipItem, data) {
            //                                 var label = 'Nombre';

            //                                 if (label) {
            //                                     label += ': ';
            //                                 }
            //                                 label += Math.round(tooltipItem.yLabel * 100) / 100;
            //                                 return label;
            //                             },
            //                             labelColor: function(tooltipItem, chart) {
            //                                 return {
            //                                     borderColor: 'rgb(255, 0, 0)',
            //                                     backgroundColor: 'rgb(255, 0, 0)'
            //                                 };
            //                             },
            //                             labelTextColor: function(tooltipItem, chart) {
            //                                 return '#ffffff';
            //                             }
            //                         }
            //                     }

            //                 }
            //             });
            //         }, error: function (data) {
            //             console.log(data)
            //         }
            //     });
            // },
            ajaxGet: function()
            {
                $.ajax({
                    url: BASE_URL+ 'medoc/test/',
                    method: "POST",
                    data:{
                     date_donne:date_donne,
                    },
                    success: function(data)
                    {
                        // Traiter les donnee
                      console.log(data);
                    }, error: function (data ) {
                        console.log(data)
                    }
                  });
            },
            getSommeDaye:function()
            {
              $.ajax({
                url: BASE_URL+ 'vente/getSommeDay',
                method: "GET",
                success: function(data)
                {
                   $('#mnt_day').text(parseInt(data) + ' FCFA');
                }, error: function (data ) {
                    console.log(data)
                }
              });
            },
            getSommeMonth:function()
            {
                $.ajax({
                    url: BASE_URL+ 'vente/getSommeMonth',
                    method: "GET",
                    success: function(data)
                    {
                        $('#mnt_mont').text(data + ' FCFA');
                    }, error: function (data) {
                        console.log(data)
                    }
                  });
            },
            getSommeYear:function()
            {
                $.ajax({
                    url: BASE_URL+ 'vente/getSommeYear',
                    method: "GET",
                    success: function(data)
                    {
                        $('#mnt_anne').text(data + ' FCFA');
                    }, error: function (data) {
                        console.log(data)
                    }
                  });
            },
            // getStatVente:function () {
            //     $.ajax({
            //         url: BASE_URL+ 'vente/statistiques',
            //         method: "GET",
            //         success: function (data) {
            //             console.log(data);
            //             var mois = [];
            //             var mois2 = [];
            //             var montant = [];
            //             var nombre = [];

            //             for (var i in data) {
            //                 if (data[i].montant != null) {
            //                     mois.push('' + data[i].mois);
            //                     mois2.push('' + data[i].mois);
            //                     montant.push(data[i].montant);
            //                     nombre.push(data[i].nombre);
            //                 }
            //             }
            //             var chardata = {
            //                 labels: mois,
            //                 datasets: [
            //                     {
            //                         label: 'Montant des ventes par mois ',
            //                         backgroundColor: [
            //                             'rgba(255, 99, 132, 0.2)',
            //                             'rgba(255, 99, 132, 0.2)',
            //                             'rgba(54, 162, 235, 0.2)',
            //                             'rgba(255, 206, 86, 0.2)',
            //                             'rgba(75, 192, 192, 0.2)',
            //                             'rgba(153, 102, 255, 0.2)',
            //                             'rgba(255, 159, 64, 0.2)',
            //                             'rgba(153, 102, 255, 0.2)',
            //                             'rgba(153, 152, 255, 0.2)',
            //                             'rgba(255, 139, 64, 0.2)',
            //                             'rgba(153, 152, 255, 0.75)',
            //                             'rgba(255, 159, 44, 0.75)',
            //                             'rgba(54, 162, 235, 0.2)',],
            //                         borderColor: [
            //                             'rgba(255, 99, 132, 1)',
            //                             'rgba(54, 162, 235, 1)',
            //                             'rgba(255, 206, 86, 1)',
            //                             'rgba(75, 192, 192, 1)',
            //                             'rgba(153, 102, 255, 1)',
            //                             'rgba(255, 159, 64, 1)',
            //                             'rgba(255, 99, 13, 1)',
            //                             'rgba(54, 100, 25, 1)',
            //                             'rgba(255, 26, 86, 1)',
            //                         ],
            //                         hoverBackgroundColor: 'rgba(200,200,200,1)',
            //                         hoverBorderColor: 'rgba(200,200,200,1)',
            //                         data: montant
            //                     }
            //                 ]
            //             };
            //             var canvas1 = document.getElementById("montantVenteMensuelle");
            //             var ctx1 = canvas1.getContext("2d");
            //             this.chart = new Chart(ctx1, {
            //                 type: 'bar',
            //                 data: chardata,
            //                 options: {
            //                     legend: {
            //                         display: true,
            //                         labels: {
            //                             fontColor: 'rgb(255, 50, 100)',
            //                             fontFamily: 'Helvetica Neue',
            //                             padding: 10,
            //                         }
            //                     },
            //                     tooltips: {
            //                         callbacks: {
            //                             label: function(tooltipItem, data) {
            //                                 var label = 'Montant';

            //                                 if (label) {
            //                                     label += ': ';
            //                                 }
            //                                 label += Math.round(tooltipItem.yLabel * 100) / 100;
            //                                 return label;
            //                             },
            //                             labelColor: function(tooltipItem, chart) {
            //                                 return {
            //                                     borderColor: 'rgb(255, 0, 0)',
            //                                     backgroundColor: 'rgb(255, 0, 0)'
            //                                 };
            //                             },
            //                             labelTextColor: function(tooltipItem, chart) {
            //                                 return '#ffffff';
            //                             }
            //                         }
            //                     }

            //                 }
            //             });

            //             var chardata1 = {
            //                 labels: mois2,
            //                 datasets: [
            //                     {
            //                         label: 'Nombre des ventes par mois ',
            //                         backgroundColor: [
            //                             'rgba(255, 99, 132, 0.2)',
            //                             'rgba(54, 162, 235, 0.2)',
            //                             'rgba(255, 206, 86, 0.2)',
            //                             'rgba(75, 192, 192, 0.2)',
            //                             'rgba(153, 102, 255, 0.2)',
            //                             'rgba(255, 159, 64, 0.2)',
            //                             'rgba(153, 102, 255, 0.2)',
            //                             'rgba(153, 152, 255, 0.2)',
            //                             'rgba(255, 139, 64, 0.2)',
            //                             'rgba(153, 152, 255, 0.2)',
            //                             'rgba(255, 159, 44, 0.2)'],
            //                         borderColor: [
            //                             'rgba(255, 99, 132, 1)',
            //                             'rgba(54, 162, 235, 1)',
            //                             'rgba(255, 206, 86, 1)',
            //                             'rgba(75, 192, 192, 1)',
            //                             'rgba(153, 102, 255, 1)',
            //                             'rgba(255, 159, 64, 1)'
            //                         ],
            //                         hoverBackgroundColor: 'rgba(250,250,200,1)',
            //                         hoverBorderColor:     'rgba(200,200,200,1)',
            //                         data: nombre
            //                     }
            //                 ]
            //             };
            //             var canvas2 = document.getElementById("nombreVenteMensuelle");
            //             var ctx2 = canvas2.getContext("2d");
            //             this.chart = new Chart(ctx2, {
            //                 type: 'bar',
            //                 data: chardata1,
            //                 options: {
            //                     legend: {
            //                         display: true,
            //                         labels: {
            //                             fontColor: 'rgb(255, 50, 100)',
            //                             fontFamily: 'Helvetica Neue',
            //                             padding: 10,
            //                         }
            //                     },
            //                     tooltips: {
            //                         callbacks: {
            //                             label: function(tooltipItem, data) {
            //                                 var label = 'Nombre';

            //                                 if (label) {
            //                                     label += ': ';
            //                                 }
            //                                 label += Math.round(tooltipItem.yLabel * 100) / 100;
            //                                 return label;
            //                             },
            //                             labelColor: function(tooltipItem, chart) {
            //                                 return {
            //                                     borderColor: 'rgb(255, 0, 0)',
            //                                     backgroundColor: 'rgb(255, 0, 0)'
            //                                 };
            //                             },
            //                             labelTextColor: function(tooltipItem, chart) {
            //                                 return '#ffffff';
            //                             }
            //                         }
            //                     }

            //                 }
            //             });
            //         }, error: function (data) {
            //             console.log(data)
            //         }
            //     });

            // },
        };
    return factory;
});


// Configuration du routage au niveau de l'app
app.config(function($routeProvider) {
    $routeProvider
        .when("/", {
            templateUrl : "page/dashboard",
        })
        .when("/list-client", {
            templateUrl : "page/list-client",
        })
        .when("/detail-client/:itemId", {
            templateUrl : "page/detail-client",
        })
        .when("/list-a-confirme", {
            templateUrl : "page/list-a-confirme",
        })
        .when("/list-demande", {
            templateUrl : "page/list-demande",
        })
        .when("/detail-demande/:itemId", {
            templateUrl : "page/detail-demande",
        })
        .when("/list-demande-encour", {
            templateUrl : "page/list-demande-encour",
        })
        .when("/list-plan", {
            templateUrl : "page/list-plan",
        })
        .when("/detail-plan/:itemId", {
            templateUrl : "page/detail-plan",
        })
        .when("/etat-vente", {
            templateUrl : "page/etat-vente",
        })
        .when("/list-a-confirme", {
            templateUrl : "page/list-a-confirme",
        }) .when("/list-plan", {
            templateUrl : "page/list-plan",
        })
        .when("/list-demande-encour", {
            templateUrl : "page/list-demande-encour",
        })
        .when("/list-demande", {
            templateUrl : "page/list-demande",
        })
        .when("/detail-client/:itemId", {
            templateUrl : "page/detail-client",
        })
        .when("/detail-demande", {
            templateUrl : "page/detail-demande",
        })
        .when("/detail-plan", {
            templateUrl : "page/detail-plan",
        })
        
});



// Spécification fonctionnelle du controller
app.controller('BackEndCtl',function (Init,$location,$scope,$filter, $log,$q,$route, $routeParams, $timeout)
{

    /*window.Echo.channel('chan-demo')
        .listen('ClientEvent', (e) => {
            console.log('arrive sur le client');
            iziToast.info({
                progressBar: false,
                title: "Notification",
                message: "Depuis angularjs",
                position: 'topRight'
            });
        });*/

    var listofrequests_assoc =
        {
            "plans"                        : [
                "id,superficie,longeur,largeur,niveauplans{id,pieces,chambre,salon,cuisine}",""
            ],

            "planprojets"                   : [
                "id,plan_id,projet_id,etat_active,message,etat,plan{id}",""
            ],

            "niveauplans"                   : [
                "id",""
            ],

            "niveauprojets"                 :  [
                "id",""
            ],

            "projets"                       :  [
                "id",""
            ],

            "typeremarques"                 : [
                "id",""
            ],

            "remarques"                     : [
                "id",""
            ],

            

            'permissions'                            : [
                                                            'id,name,display_name,guard_name',
                                                              ""
                                                        ],

            "roles"                                  : [
                                                        "id,name,guard_name,permissions{id,name,display_name,guard_name}",
                                                         ""
                                                    ],

            "users"                                  : [
                                                            "id,name,email,active,password,image,roles{id,name,guard_name,permissions{id,name,display_name,guard_name}}",
                                                            ",last_login,last_login_ip,created_at_fr,ventes{id},recouvrements{id},clotures{id},versements{id},bon_commandes{id},bon_livraisons{id},facture_proformas{id},retours{id},entree_stocks{id},sortie_stocks{id}"
                                                        ],

            "dashboards"                             : [
                                                        "clients,assurances,ventes,fournisseurs"
                                                    ],

            

        };

    //--DEBUT => Donne la qté  par rapport à la quantité total--//
    $scope.donneClient = function () {
        var retour = 0;
        var qte = 0;
        idclient = $(".select2.search_client").val();

        if (idclient)
        {
            console.log("ID PRODUIT ==> " + idclient);
            var typeAvecS = "clients";
            var rewriteReq = typeAvecS
                + "(id:" + idclient
                + ")";

            Init.getElement(rewriteReq, "assurance_id,matricule,pourcentage,souscripteur,affiles{id,nomcomplet}").then(function (data) {

                if (data) {
                    items = data[0];

                    console.log(items);
                    $('#assurance_vente').val(items.assurance_id);
                    $('#matriculepatient_vente').val(items.matricule);
                    $('#tauxpriseencharge_vente').val(items.pourcentage);
                    $('#souscripteur_vente').val(items.souscripteur);
                    $scope.affiles = items.affiles
                    $('#affile_vente').val(items.affiles[0].id);
                }

            }, function (msg) {
                toastr.error(msg);
            });
        }
        return retour;
    };
    setTimeout(function () {
        $('select.select2').select2(
            {
                width: 'resolve',
                tags: true
            }
        )
            .on('change', function (e) {
                //console.log("icicic", $("#designation_produitclient").val())
                var getId = $(this).attr("id");
                console.log("Id", getId)
                if (getId.indexOf('vente') !== -1 ) {
                    setTimeout(function () {
                        $scope.donneClient();

                    },300);
                }
            });
    }, 500);




    //
    $scope.imgupload_location = imgupload;

    // Pharmacie
    $scope.plans = [];
    $scope.planprojets = [];
    $scope.niveauplans = [];
    $scope.niveauprojets = [];
    $scope.projets = [];
    $scope.typeremarques = [];
    $scope.remarques = [];
    $scope.users = [];
    

    $scope.tot_day = 0;
    $scope.tot_month = 0;
    $scope.tot_year = 0;

    // for pagination

    $scope.paginationmedicament = {
        currentPage: 1,
        maxSize: 10,
        entryLimit: 10,
        totalItems: 0
    };
    $scope.paginationplan = {
        currentPage: 1,
        maxSize: 10,
        entryLimit: 10,
        totalItems: 0
    };
    $scope.paginationdepense = {
        currentPage: 1,
        maxSize: 10,
        entryLimit: 10,
        totalItems: 0
    };

    $scope.paginationfactureproforma = {
        currentPage: 1,
        maxSize: 10,
        entryLimit: 10,
        totalItems: 0
    };

    $scope.paginationcaisse = {
        currentPage: 1,
        maxSize: 10,
        entryLimit: 10,
        totalItems: 0
    };

    $scope.paginationvente = {
        currentPage: 1,
        maxSize: 10,
        entryLimit: 10,
        totalItems: 0
    };

    $scope.paginationassurance = {
        currentPage: 1,
        maxSize: 10,
        entryLimit: 10,
        totalItems: 0
    };
    $scope.paginationfournisseur = {
        currentPage: 1,
        maxSize: 10,
        entryLimit: 10,
        totalItems: 0
    };
    $scope.paginationboncommande = {
        currentPage: 1,
        maxSize: 10,
        entryLimit: 10,
        totalItems: 0
    };
    $scope.paginationbonlivraison = {
        currentPage: 1,
        maxSize: 10,
        entryLimit: 10,
        totalItems: 0
    };
    $scope.paginationrecouvrement = {
        currentPage: 1,
        maxSize: 10,
        entryLimit: 10,
        totalItems: 0
    };

    $scope.paginationcli = {
        currentPage: 1,
        maxSize: 10,
        entryLimit: 10,
        totalItems: 0
    };

    $scope.paginationuser = {

        currentPage: 1,
        maxSize: 10,
        entryLimit: 10,
        totalItems: 0
    };

    $scope.paginationversement = {
        currentPage: 1,
        maxSize: 10,
        entryLimit: 10,
        totalItems: 0
    };

    $scope.paginationcloture = {
        currentPage: 1,
        maxSize: 10,
        entryLimit: 10,
        totalItems: 0
    };
$scope.get_Somme_daye = function ()
{
    $.ajax({
        url: BASE_URL+ 'vente/getSommeDay',
        method: "GET",
        success: function(data)
        {
            console.log(data);
        }, error: function (data) {
            console.log(data)
        }
      });
};
  $scope.getCaisse = function (data)
  {
      var dta1 = data.date_donne
      console.log(dta1);
      Init.journalCaisseDate(dta1);
  };
    $scope.filtreChambreByTypeChambre = function(e, type_chambre_id)
    {
        $scope.occupationByTypeChambre = type_chambre_id;
        console.log('arrive sur le filtre', type_chambre_id);

        $scope.getelements("infoaffiliations");

        var data_id = type_chambre_id==null ? 0: type_chambre_id;
        $('.type_chambre').each(function(key, value)
        {
            $(this).removeClass('bg-dark text-white');
            if (Number($(this).attr('data-id'))== Number(data_id))
            {
                $(this).addClass('bg-dark text-white');
            }
        });

    };

    // Pour réecrire l'url pour les filtres fichiers à télécharger
    $scope.urlWrite = "";
    $scope.writeUrl = function (type, addData=null)
    {
        var urlWrite = "";

        $("input[id$=" + type + "], textarea[id$=" + type + "], select[id$=" + type + "]").each(function ()
        {
            var attr = $(this).attr("id").substr(0, $(this).attr("id").length - (type.length + 1 ));
            urlWrite = urlWrite + ($(this).val() && $(this).val()!=="" ? (urlWrite ? "&" : "") + attr + '=' + $(this).val() : "" );
        });

        $scope.urlWrite = urlWrite ? "?" + urlWrite : urlWrite;
    };


    $scope.getelements = function (type, addData=null, forModal = false, nullableAddToReq = false)
    {
        rewriteType = type;

        if ($scope.pageCurrent!=null)
        {
            if($scope.pageCurrent.indexOf("reservation")!==-1)
            {
                /*if (type.indexOf('plannings')!==-1)
                {
                    rewriteType = rewriteType + "(etat:1)";
                }*/
            }
            else if ($scope.pageCurrent.indexOf("tarif")!==-1)
            {
                if (type.indexOf('tarifs')!==-1)
                {
                    rewriteType = rewriteType + "(default:true"
                        + ($('#typetarif_listtarif').val() ? ',type_tarif_id:' + $('#typetarif_listtarif').val() : "" )
                        + ")";
                }
            }
            else if ($scope.pageCurrent.indexOf("salle")!==-1)
            {
                if (type.indexOf('salles')!==-1)
                {
                    rewriteType = rewriteType + "(default:true"
                        + ($('#zone_listsalle').val() ? ',zone_id:' + $('#zone_listsalle').val() : "" )
                        + ")";
                }
            }
        }
        if (type.indexOf('dashboards')!==-1)
        {
            // addData = $scope.infosDahboardBy
            rewriteType = rewriteType + "("
                /* = listinfos*/ + ($('#info_' + addData).val() ? ',date_' + addData + ':' + '"' + $('#info_' + addData).val() + '"' : "current_"+(addData)+":true" )
                + ")";
        }
        if (type.indexOf('medicaments')!==-1 )
        {
            console.log('je suis ici');

            if ($scope.pageUpload)
            {
                rewriteType = rewriteType + "("
                    + ($('#searchtexte_listmedicament').val() ? (',' + $('#searchoption_listmedicament').val() + ':"' + $('#searchtexte_listmedicament').val() + '"') : "" )
                    + ($('#designationmedicament_listmedicament').val() ? ',designation:"' + $('#designationmedicament_listmedicament').val() + '"' : "" )
                    + ($('#typemedicament_listmedicament').val() ? ',type_medicament_id:' + $('#typemedicament_listmedicament').val() : "" )
                    + ($('#famillemedicament_listmedicament').val() ? ',famille_medicament_id:' + $('#famillemedicament_listmedicament').val() : "" )
                    + ($('#categoriemedicament_listmedicament').val() ? ',categorie_id:' + $('#categoriemedicament_listmedicament').val() : "" )
                    + ($('#lettre_debut_listmedicament').val() ? ',letter_start:' + '"' + $('#lettre_debut_listmedicament').val() + '"' : "" )
                    + ($('#lettre_fin_listmedicament').val() ? ',letter_end:' + '"' + $('#lettre_fin_listmedicament').val() + '"' : "" )
                    +')';
                $scope.requetteTabMedicament = ""
                    + ($('#cip_fichiermedicament').val() ? (',' + $('#searchoption_listmedicament').val() + ':"' + $('#cip_fichiermedicament').val() + '"') : "" )
                    + ($('#designation_fichiermedicament').val() ? ',designation:"' + $('#designation_fichiermedicament').val() + '"' : "" )
                    + ($('#type_fichiermedicament').val() ? ',type_medicament_id:' + $('#type_fichiermedicament').val() : "" )
                    + ($('#famille_fichiermedicament').val() ? ',famille_medicament_id:' + $('#famille_fichiermedicament').val() : "" )
                    + ($('#tableau_fichiermedicament').val() ? ',categorie_id:' + $('#tableau_fichiermedicament').val() : "" )
                    + ($('#lettre_debut_fichiermedicament').val() ? ',letter_start:' + '"' + $('#lettre_debut_fichiermedicament').val() + '"' : "" )
                    + ($('#lettre_fin_fichiermedicament').val() ? ',letter_end:' + '"' + $('#lettre_fin_fichiermedicament').val() + '"' : "" );
                $scope.requeteEtatStock = ""
                    + ($('#designation_etatstockmedicament').val() ? ',designation:"' + $('#designation_etatstockmedicament').val() + '"' : "" )
                    + ($('#type_etatstockmedicament').val() ? ',type_medicament_id:' + $('#type_etatstockmedicament').val() : "" )
                    + ($('#famille_etatstockmedicament').val() ? ',famille_medicament_id:' + $('#famille_etatstockmedicament').val() : "" )
                    + ($('#tableau_etatstockmedicament').val() ? ',categorie_id:' + $('#tableau_etatstockmedicament').val() : "" )
                    + ($('#lettre_debut_etatstockmedicament').val() ? ',letter_start:' + '"' + $('#lettre_debut_etatstockmedicament').val() + '"' : "" )
                    + ($('#lettre_fin_etatstockmedicament').val() ? ',letter_end:' + '"' + $('#lettre_fin_etatstockmedicament').val() + '"' : "" )
                    + ($('#date_etatstockmedicament').val() ? ',date:' + '"' + $('#date_etatstockmedicament').val() + '"' : "" );

                $scope.requeteFournisseur = ""
                    + ($('#fournisseur_etatachatfournisseur').val() ? ',fournisseur_id:"' + $('#fournisseur_etatachatfournisseur').val() + '"' : "" )
                    + ($('#date_etatachatfournisseur').val() ? ',date:"' + $('#date_etatachatfournisseur').val() + '"' : "" )
                    + ($('#date_end_etatachatfournisseur').val() ? ',date_end:"' + $('#date_end_etatachatfournisseur').val() + '"' : "" )

                $scope.requeteEtatVente = ""
                    + ($('#date_debut_etatvente').val() ? ',date_debut:"' + $('#date_etatvente').val() + '"' : "" )
                    + ($('#date_fin_etatvente').val() ? ',date_fin:"' + $('#date_etatvente').val() + '"' : "" )
                    + ($('#liste_client_etatvente').val() ? ',liste_client:"' + $('#liste_client_etatvente').val() + '"' : "" )
                    + ($('#modepaiement_etatvente').val() ? ',modepaiement:"' + $('#modepaiement_etatvente').val() + '"' : "" )
                    + ($('#famille_etatvente').val() ? ',famille:"' + $('#famille_etatvente').val() + '"' : "" )
                    + ($('#categorie_etatvente').val() ? ',categorie:"' + $('#categorie_etatvente').val() + '"' : "" )
                    + ($('#designation_etatvente').val() ? ',designation:"' + $('#designation_etatvente').val() + '"' : "" )
                    + ($('#typemedicament_etatvente').val() ? ',typemedicament:"' + $('#typemedicament_etatvente').val() + '"' : "" )

                $scope.requeteEtatLivraison = ""
                    + ($('#date_debut_etatlivraisons').val() ? ',date_debut:"' + $('#date_debut_etatlivraisons').val() + '"' : "" )
                    + ($('#date_fin_etatlivraisons').val() ? ',date_fin:"' + $('#date_fin_etatlivraisons').val() + '"' : "" )

                $scope.requeteEtatBonCommande = ""
                    + ($('#date_debut_etatcommandes').val() ? ',date_debut:"' + $('#date_debut_etatcommandes').val() + '"' : "" )
                    + ($('#date_fin_etatcommandes').val() ? ',date_fin:"' + $('#date_fin_etatcommandes').val() + '"' : "" )

                $scope.requeteEtatDepense = ""
                    + ($('#date_debut_etatdepenses').val() ? ',date_debut:"' + $('#date_debut_etatdepenses').val() + '"' : "" )
                    + ($('#date_fin_etatdepenses').val() ? ',date_fin:"' + $('#date_fin_etatdepenses').val() + '"' : "" )
                    + ($('#caisse_etatdepenses').val() ? ',caisse:"' + $('#caisse_etatdepenses').val() + '"' : "" )

                $scope.requeteEtatVenteModePaiement = ""
                    + ($('#date_etatventemodepaiement').val() ? ',date:"' + $('#date_etatventemodepaiement').val() + '"' : "" )
                    + ($('#modepaiement_etatventemodepaiement').val() ? ',modepaiement:"' + $('#modepaiement_etatventemodepaiement').val() + '"' : "" )

            }
        }
        if (type.indexOf('fournisseurs')!== -1)
        {
            if ($scope.pageUpload)
            {
                $scope.requeteFournisseur = ""
                    + ($('#fournisseur_etatachatfournisseur').val() ? ',fournisseur_id:"' + $('#fournisseur_etatachatfournisseur').val() + '"' : "" )
                    + ($('#date_etatachatfournisseur').val() ? ',date:"' + $('#date_etatachatfournisseur').val() + '"' : "" )
            }
        }

        $add_to_req =  (listofrequests_assoc[type].length > 1 && !nullableAddToReq) ? listofrequests_assoc[type][1] : null;
        Init.getElement(rewriteType, listofrequests_assoc[type] + $add_to_req).then(function(data)
        {
            if (type.indexOf("typeclients")!==-1)
            {
                $scope.typeclients = data;
            }
            else if (type.indexOf("plans")!==-1)
            {
                $scope.plans = data;
            }
            else if (type.indexOf("planprojets")!==-1)
            {
                $scope.planprojets = data;
            }
            else if (type.indexOf("niveauplans")!==-1)
            {
                $scope.niveauplans = data;
            }
            else if (type.indexOf("niveauprojets")!==-1)
            {
                $scope.niveauprojets = data;
            }
            else if (type.indexOf("projets")!==-1)
            {
                $scope.projets = data;
            }
            else if (type.indexOf("typeremarques")!==-1)
            {
                $scope.typeremarques = data;
            }
            else if (type.indexOf("remarques")!==-1)
            {
                $scope.remarques = data;
            }
            else if (type.indexOf("modepaiements")!==-1)
            {
                $scope.modepaiements = data;
            }
            else if (type.indexOf("caisses")!==-1)
            {
                $scope.caisses = data;
            }
            else if (type.indexOf("typemedicaments")!==-1)
            {
                $scope.typemedicaments = data;
            }
            else if (type.indexOf("typemotifs")!==-1)
            {
                $scope.typemotifs = data;
            }
            else if (type.indexOf("motifs")!==-1)
            {
                $scope.motifs = data;
            }
            else if (type.indexOf("famillemedicaments")!==-1)
            {
                $scope.famillemedicaments = data;
            }
            else if (type.indexOf("categories")!==-1)
            {
                $scope.categories = data;
            }
            else if (type.indexOf("recouvrements")!==-1)
            {
                $scope.recouvrements = data;
            }
            else if (type.indexOf("ventes")!==-1)
            {
                $scope.ventes = data;
            }
            else if (type.indexOf("boncommandes")!==-1)
            {
                $scope.boncommandes = data;
            }
            else if (type.indexOf("bonlivraisons")!==-1)
            {
                $scope.bonlivraisons = data;
            }
            else if (type.indexOf("coachpratiques")!==-1)
            {
                $scope.coachpratiques = data;
            }
            else if (type.indexOf("pratiques")!==-1)
            {
                $scope.pratiques = data;
            }
            else if (type.indexOf("versements")!==-1)
            {
                $scope.versements = data;
            }
            else if (type.indexOf("depenses")!==-1)
            {
                $scope.depenses = data;
            }
            else if (type.indexOf("clotures")!==-1)
            {
                $scope.clotures = data;
            }
            else if (type.indexOf("zonelivraisons")!==-1)
            {
                $scope.zonelivraisons = data;
            }
            else if (type.indexOf("typelivraisons")!==-1)
            {
                $scope.typelivraisons = data;
            }
            else if (type.indexOf("zones")!==-1)
            {
                $scope.zones = data;
            }
            else if (type.indexOf("monaies")!==-1)
            {
                $scope.monaies = data;
            }
            else if (type.indexOf("frequences")!==-1)
            {
                $scope.frequences = data;
            }
            else if (type.indexOf("salles")!==-1)
            {
                $scope.salles = data;
            }
            else if (type.indexOf("coachs")!==-1)
            {
                $scope.coachs = data;
            }
            else if (type.indexOf("clients")!==-1)
            {
                $scope.clients = data;
            }
            else if (type.indexOf("assurances")!==-1)
            {
                $scope.assurances = data;
            }
            else if (type.indexOf("levels")!==-1)
            {
                $scope.levels = data;
            }
            else if (type.indexOf("plannings")!==-1)
            {
                $scope.plannings = data;
            }
            else if (type.indexOf("abonnements")!==-1)
            {
                $scope.abonnements = data;
            }
            else if (type.indexOf("paiements")!==-1)
            {
                $scope.paiements = data;
            }
            else if (type.indexOf("typeproduits")!==-1)
            {
                $scope.typeproduits = data;
            }
            else if (type.indexOf("medicaments")!==-1)
            {
                $scope.medicaments = data;
            }
            else if (type.indexOf("typeingredients")!==-1)
            {
                $scope.typeingredients = data;
            }
            else if (type.indexOf("ingredients")!==-1)
            {
                $scope.produits = data;
            }
            else if (type.indexOf("permissions")!==-1)
            {
                $scope.permissions = data;
            }
            else if (type.indexOf("roles")!==-1)
            {
                if (forModal)
                {
                    $scope.roles_modal = data;
                }
                else
                {
                    $scope.roles = data;
                }
            }
            else if (type.indexOf("users")!==-1)
            {
                $scope.users = data;
            }
            else if (type.indexOf("dashboards")!==-1)
            {
                   //  $scope.dashboard_data = data;
                   //  $scope.dashboard_data[0].ventes = JSON.parse(data[0].ventes);
                   //   $scope.dashboard_data[0].assurances = JSON.parse(data[0].assurances);
                   //   $scope.dashboard_data[0].clients = JSON.parse(data[0].clients);
                   //   $scope.dashboard_data[0].fournisseurs = JSON.parse(data[0].fournisseurs);
                    //$scope.dashboard_data[0].top_vente = JSON.parse(data[0].top_vente);
                    //$scope.dashboard_data[0].fake_ventes = JSON.parse(data[0].fake_ventes);
                console.log('infos du dashboards', data);

            }
            else if (type.indexOf("detailsinventaires")!==-1)
            {
                $scope.detailsinventaires = data;
            }
        }, function (msg) {
            iziToast.error({
                title: "ERREUR",
                message: msg_erreur,
                position: 'topRight'
            });
            console.log('Erreur serveur ici = ' + msg);
        });

    };

    $scope.searchtexte_client = "";
    $scope.pageChanged = function(currentpage)
    {
        if ( currentpage.indexOf('assurance')!==-1 )
        {
            rewriteelement = 'assurancespaginated(page:'+ $scope.paginationassurance.currentPage +',count:'+ $scope.paginationassurance.entryLimit
                + ($('#searchtexte_assurance').val() ? (',' + $('#searchoption_assurance').val() + ':"' + $('#searchtexte_assurance').val() + '"') : "" )
                +')';
            // blockUI_start_all('#section_listeclients');
            Init.getElementPaginated(rewriteelement, listofrequests_assoc["assurances"]).then(function (data)
            {
                // blockUI_stop_all('#section_listeclients');
                console.log(data);
                // pagination controls
                $scope.paginationassurance = {
                    currentPage: data.metadata.current_page,
                    maxSize: 10,
                    entryLimit: $scope.paginationassurance.entryLimit,
                    totalItems: data.metadata.total
                };
                $scope.assurances = data.data;
            },function (msg)
            {
                toastr.error(msg);
            });
        }
        else if ( currentpage.indexOf('plan')!==-1 )
        {
            rewriteelement = 'planspaginated(page:'+ $scope.paginationplan.currentPage +',count:'+ $scope.paginationplan.entryLimit
                + ($scope.planview ? ',plan_id:' + $scope.planview.id : "" )
                + ($('#searchtexte_fournisseur').val() ? (',' + $('#searchoption_fournisseur').val() + ':"' + $('#searchtexte_fournisseur').val() + '"') : "" )
                +')';
            $scope.requetePlan = ""

            // blockUI_start_all('#section_listeclients');

            Init.getElementPaginated(rewriteelement, listofrequests_assoc["plans"]).then(function (data)
            {
                // blockUI_stop_all('#section_listeclients');
                console.log(data);
                // pagination controls
                $scope.paginationplan = {
                    currentPage: data.metadata.current_page,
                    maxSize: 10,
                    entryLimit: $scope.paginationplan.entryLimit,
                    totalItems: data.metadata.total
                };
                // $scope.noOfPages_produit = data.metadata.last_page;
                $scope.plans = data.data;
            },function (msg)
            {
                // blockUI_stop_all('#section_listeclients');
                toastr.error(msg);
            });
        }
        else if ( currentpage.indexOf('recouvrement')!==-1 )
        {
            rewriteelement = 'recouvrementspaginated(page:'+ $scope.paginationrecouvrement.currentPage +',count:'+ $scope.paginationrecouvrement.entryLimit
                + ($scope.userview ? ',user_id:' + $scope.userview.id : "" )
                + ($scope.clientview ? ',client_id:' + $scope.clientview.id : "" )
                + ($scope.caisseview ? ',caisse_id:' + $scope.caisseview.id : "" )
                + ($scope.assuranceview ? ',assurance_id:' + $scope.assuranceview.id : "" )
                + ($('#assurance_listrecouvrement').val() ? ',assurance_id:' + $('#assurance_listrecouvrement').val() : "" )
                + ($('#client_listrecouvrement').val() ? ',client_id:' + $('#client_listrecouvrement').val() : "" )
                + ($('#user_listrecouvrement').val() ? ',user_id:' + $('#user_listrecouvrement').val() : "" )
                + ($('#created_at_start_listrecouvrement').val() ? ',created_at_start:' + '"' + $('#created_at_start_listrecouvrement').val() + '"' : "" )
                + ($('#created_at_end_listrecouvrement').val() ? ',created_at_end:' + '"' + $('#created_at_end_listrecouvrement').val() + '"' : "" )
                +')';
            // blockUI_start_all('#section_listeclients');
            Init.getElementPaginated(rewriteelement, listofrequests_assoc["recouvrements"]).then(function (data)
            {
                // blockUI_stop_all('#section_listeclients');
                console.log(data);
                // pagination controls
                $scope.paginationrecouvrement = {
                    currentPage: data.metadata.current_page,
                    maxSize: 10,
                    entryLimit: $scope.paginationrecouvrement.entryLimit,
                    totalItems: data.metadata.total
                };
                // $scope.noOfPages_produit = data.metadata.last_page;
                $scope.recouvrements = data.data;
            },function (msg)
            {
                // blockUI_stop_all('#section_listeclients');
                toastr.error(msg);
            });
        }
        else if ( currentpage.indexOf('client')!==-1 )
        {
            rewriteelement = 'clientspaginated(page:'+ $scope.paginationcli.currentPage +',count:'+ $scope.paginationcli.entryLimit
                + ($('#searchtexte_client').val() ? (',' + $('#searchoption_client').val() + ':"' + $('#searchtexte_client').val() + '"') : "" )
                + ($('#typeclient_listclient').val() ? ',type_client_id:' + $('#typeclient_listclient').val() : "" )
                + ($('#zone_listclient').val() ? ',zone_livraison_id:' + $('#zone_listclient').val() : "" )
                +')';
            // blockUI_start_all('#section_listeclients');
            Init.getElementPaginated(rewriteelement, listofrequests_assoc["clients"]).then(function (data)
            {
                // blockUI_stop_all('#section_listeclients');
                console.log(data);
                // pagination controls
                $scope.paginationcli = {
                    currentPage: data.metadata.current_page,
                    maxSize: 10,
                    entryLimit: $scope.paginationcli.entryLimit,
                    totalItems: data.metadata.total
                };
                // $scope.noOfPages_produit = data.metadata.last_page;
                $scope.clients = data.data;
            },function (msg)
            {
                // blockUI_stop_all('#section_listeclients');
                toastr.error(msg);
            });
        }
        else if ( currentpage.indexOf('boncommande')!==-1 )
        {
            rewriteelement = 'boncommandespaginated(page:'+ $scope.paginationboncommande.currentPage +',count:'+ $scope.paginationboncommande.entryLimit
                + ($scope.userview ? ',user_id:' + $scope.userview.id : "" )
                + ($scope.fournisseurview ? ',fournisseur_id:' + $scope.fournisseurview.id : "" )
                + ($scope.factureproformaview ? ',facture_proforma_id:' + $scope.factureproformaview.id : "" )
                + ($('[name="etatlivraison_listboncommande"]:checked').attr('data-value') ? ',etat_livraison:' + '"' + $('[name="etatlivraison_listboncommande"]:checked').attr('data-value') + '"' : "" )
                + ($('#codebc_listboncommande').val() ? ',code_bc:' + '"' + $('#codebc_listboncommande').val() + '"' : "" )
                + ($('#fournisseur_listboncommande').val() ? ',fournisseur_id:' + $('#fournisseur_listboncommande').val() : "" )
                + ($('#user_listboncommande').val() ? ',user_id:' + $('#user_listboncommande').val() : "" )
                + ($('#created_at_start_listboncommande').val() ? ',created_at_start:' + '"' + $('#created_at_start_listboncommande').val() + '"' : "" )
                + ($('#created_at_end_listboncommande').val() ? ',created_at_end:' + '"' + $('#created_at_end_listboncommande').val() + '"' : "" )
                +')';
            // blockUI_start_all('#section_listeclients');
            Init.getElementPaginated(rewriteelement, listofrequests_assoc["boncommandes"]).then(function (data)
            {
                // blockUI_stop_all('#section_listeclients');
                // pagination controls
                $scope.paginationboncommande = {
                    currentPage: data.metadata.current_page,
                    maxSize: 10,
                    entryLimit: $scope.paginationboncommande.entryLimit,
                    totalItems: data.metadata.total
                };
                $scope.boncommandes = data.data;
            },function (msg)
            {
                // blockUI_stop_all('#section_listeclients');
                toastr.error(msg);
            });
        }
        else if ( currentpage.indexOf('bonlivraison')!==-1 )
        {
            rewriteelement = 'bonlivraisonspaginated(page:'+ $scope.paginationbonlivraison.currentPage +',count:'+ $scope.paginationbonlivraison.entryLimit
                + ($scope.medicamentview ? ',medicament_id:' + $scope.medicamentview.id : "" )
                + ($scope.userview ? ',user_id:' + $scope.userview.id : "" )
                + ($scope.boncommandeview ? ',bon_commande_id:' + $scope.boncommandeview.id : "" )
                + ($scope.fournisseurview ? ',fournisseur_id:' + $scope.fournisseurview.id : "" )
                + ($('#fournisseur_listbonlivraison').val() ? ',fournisseur_id:' + $('#fournisseur_listbonlivraison').val() : "" )
                + ($('#commande_listbonlivraison').val() ? ',bon_commande_id:' + $('#commande_listbonlivraison').val() : "" )
                /* = listreservation*/ + ($('#searchnumeroblfournisseur_listbonlivraison').val() ? ',numero_bl_fournisseur:' + '"' + $('#searchnumeroblfournisseur_listbonlivraison').val() + '"' : "" )
                /* = listreservation*/ + ($('#searchcodebl_listbonlivraison').val() ? ',code_livraison:' + '"' + $('#searchcodebl_listbonlivraison').val() + '"' : "" )
                /* = listreservation*/ + ($('#searchcodebc_listbonlivraison').val() ? ',code_bc:' + '"' + $('#searchcodebc_listbonlivraison').val() + '"' : "" )
                + ($('#user_listbonlivraison').val() ? ',user_id:' + $('#user_listbonlivraison').val() : "" )
                + ($('#created_at_start_listbonlivraison').val() ? ',created_at_start:' + '"' + $('#created_at_start_listbonlivraison').val() + '"' : "" )
                + ($('#created_at_end_listbonlivraison').val() ? ',created_at_end:' + '"' + $('#created_at_end_listbonlivraison').val() + '"' : "" )
                + ($('#date_start_listbonlivraison').val() ? ',date_start_bl_fournisseur:' + '"' + $('#date_start_listbonlivraison').val() + '"' : "" )
                + ($('#date_end_listbonlivraison').val() ? ',date_end_bl_fournisseur:' + '"' + $('#date_end_listbonlivraison').val() + '"' : "" )

                +')';
            // blockUI_start_all('#section_listeclients');
            Init.getElementPaginated(rewriteelement, listofrequests_assoc["bonlivraisons"]).then(function (data)
            {
                // blockUI_stop_all('#section_listeclients');
                // pagination controls
                $scope.paginationbonlivraison = {
                    currentPage: data.metadata.current_page,
                    maxSize: 10,
                    entryLimit: $scope.paginationbonlivraison.entryLimit,
                    totalItems: data.metadata.total
                };
                $scope.bonlivraisons = data.data;
            },function (msg)
            {
                // blockUI_stop_all('#section_listeclients');
                toastr.error(msg);
            });
        }
        else if ( currentpage.indexOf('versement')!==-1 )
        {
            rewriteelement = 'versementspaginated(page:'+ $scope.paginationversement.currentPage +',count:'+ $scope.paginationversement.entryLimit
                + ($scope.caisseview ? ',caisse_id:' + $scope.caisseview.id : "" )
                + ($scope.userview ? ',user_id:' + $scope.userview.id : "" )
                + ($('#caisse_listversement').val() ? ',caisse_id:' + $('#caisse_listversement').val() : "" )
                + ($('#user_listversemment').val() ? ',user_id:' + $('#user_listversemment').val() : "" )
                /* = listreservation*/ + ($('#created_at_start_listversement').val() ? ',created_at_start:' + '"' + $('#created_at_start_listversement').val() + '"' : "" )
                /* = listreservation*/ + ($('#created_at_end_listversement').val() ? ',created_at_end:' + '"' + $('#created_at_end_listversement').val() + '"' : "" )
                +')';
            // blockUI_start_all('#section_listeclients');
            Init.getElementPaginated(rewriteelement, listofrequests_assoc["versements"]).then(function (data)
            {
                // blockUI_stop_all('#section_listeclients');
                // pagination controls
                $scope.paginationversement = {
                    currentPage: data.metadata.current_page,
                    maxSize: 10,
                    entryLimit: $scope.paginationversement.entryLimit,
                    totalItems: data.metadata.total
                };
                $scope.versements = data.data;
            },function (msg)
            {
                // blockUI_stop_all('#section_listeclients');
                toastr.error(msg);
            });
        }
        else if ( currentpage.indexOf('depense')!==-1 )
        {
            rewriteelement = 'depensespaginated(page:'+ $scope.paginationdepense.currentPage +',count:'+ $scope.paginationdepense.entryLimit
                + ($scope.caisseview ? ',caisse_id:' + $scope.caisseview.id : "" )
                + ($scope.userview ? ',user_id:' + $scope.userview.id : "" )
                + ($('#caisse_listdepense').val() ? ',caisse_id:' + $('#caisse_listdepense').val() : "" )
                + ($('#user_listdepense').val() ? ',user_id:' + $('#user_listdepense').val() : "" )
                /* = listreservation*/ + ($('#created_at_start_listdepense').val() ? ',created_at_start:' + '"' + $('#created_at_start_listdepense').val() + '"' : "" )
                /* = listreservation*/ + ($('#created_at_end_listdepense').val() ? ',created_at_end:' + '"' + $('#created_at_end_listdepense').val() + '"' : "" )
                +')';
            // blockUI_start_all('#section_listeclients');
            Init.getElementPaginated(rewriteelement, listofrequests_assoc["depenses"]).then(function (data)
            {
                // blockUI_stop_all('#section_listeclients');
                // pagination controls
                $scope.paginationdepense = {
                    currentPage: data.metadata.current_page,
                    maxSize: 10,
                    entryLimit: $scope.paginationdepense.entryLimit,
                    totalItems: data.metadata.total
                };
                $scope.depenses = data.data;
            },function (msg)
            {
                // blockUI_stop_all('#section_listeclients');
                toastr.error(msg);
            });
        }
        else if ( currentpage.indexOf('cloture')!==-1 )
        {
            rewriteelement = 'cloturespaginated(page:'+ $scope.paginationcloture.currentPage +',count:'+ $scope.paginationcloture.entryLimit
                + ($scope.caisseview ? ',caisse_id:' + $scope.caisseview.id : "" )
                + ($scope.userview ? ',user_id:' + $scope.userview.id : "" )
                + ($('#caisse_listcloture').val() ? ',caisse_id:' + $('#caisse_listcloture').val() : "" )
                + ($('#user_listcloture').val() ? ',user_id:' + $('#user_listcloture').val() : "" )
                /* = listreservation*/ + ($('#created_at_start_listcloture').val() ? ',created_at_start:' + '"' + $('#created_at_start_listcloture').val() + '"' : "" )
                /* = listreservation*/ + ($('#created_at_end_listcloture').val() ? ',created_at_end:' + '"' + $('#created_at_end_listcloture').val() + '"' : "" )
                /* = listreservation*/ + ($('#date_start_listcloture').val() ? ',date_start:' + '"' + $('#date_start_listcloture').val() + '"' : "" )
                /* = listreservation*/ + ($('#date_end_listcloture').val() ? ',date_end:' + '"' + $('#date_end_listcloture').val() + '"' : "" )
                +')';
            // blockUI_start_all('#section_listeclients');
            Init.getElementPaginated(rewriteelement, listofrequests_assoc["clotures"]).then(function (data)
            {
                // blockUI_stop_all('#section_listeclients');
                // pagination controls
                $scope.paginationcloture = {
                    currentPage: data.metadata.current_page,
                    maxSize: 10,
                    entryLimit: $scope.paginationcloture.entryLimit,
                    totalItems: data.metadata.total
                };
                $scope.clotures = data.data;
            },function (msg)
            {
                // blockUI_stop_all('#section_listeclients');
                toastr.error(msg);
            });
        }
        else if ( currentpage.indexOf('sortiestock')!==-1 )
        {
            rewriteelement = 'sortiestockspaginated(page:'+ $scope.paginationsortiestock.currentPage +',count:'+ $scope.paginationsortiestock.entryLimit
                + ($scope.userview ? ',user_id:' + $scope.userview.id : "" )
                + ($scope.medicamentview ? ',medicament_id:' + $scope.medicamentview.id : "" )
                + ($('#motif_listsortiestock').val() ? ',motif_id:' + $('#motif_listsortiestock').val() : "" )
                + ($('#user_listsortiestock').val() ? ',user_id:' + $('#user_listsortiestock').val() : "" )
                /* = list*/ + ($('#created_at_start_listsortiestock').val() ? ',created_at_start:' + '"' + $('#created_at_start_listsortiestock').val() + '"' : "" )
                /* = list*/ + ($('#created_at_end_listsortiestock').val() ? ',created_at_end:' + '"' + $('#created_at_end_listsortiestock').val() + '"' : "" )
                +')';
            // blockUI_start_all('#section_listeclients');
            Init.getElementPaginated(rewriteelement, listofrequests_assoc["sortiestocks"]).then(function (data)
            {
                // blockUI_stop_all('#section_listeclients');
                console.log(data);
                // pagination controls
                $scope.paginationsortiestock = {
                    currentPage: data.metadata.current_page,
                    maxSize: 10,
                    entryLimit: $scope.paginationsortiestock.entryLimit,
                    totalItems: data.metadata.total
                };
                // $scope.noOfPages_produit = data.metadata.last_page;
                $scope.sortiestocks = data.data;
            },function (msg)
            {
                // blockUI_stop_all('#section_listeclients');
                toastr.error(msg);
            });
        }
        else if ( currentpage.indexOf('retour')!==-1 )
        {
            rewriteelement = 'retourspaginated(page:'+ $scope.paginationretour.currentPage +',count:'+ $scope.paginationretour.entryLimit
                + ($scope.fournisseurview ? ',fournisseur_id:' + $scope.fournisseurview.id : "" )
                + ($('#fournisseur_listretour').val() ? ',fournisseur_id:' + $('#fournisseur_listretour').val() : "" )
                + ($('#motif_listretour').val() ? ',motif_id:' + $('#motif_listretour').val() : "" )
                + ($('#bl_listretour').val() ? ',bon_livraison_id:' + $('#bl_listretour').val() : "" )
                + ($scope.userview ? ',user_id:' + $scope.userview.id : "" )
                + ($('#user_listretour').val() ? ',user_id:' + $('#user_listretour').val() : "" )
                + ($('[name="etat_listretour"]:checked').attr('data-value') ? ',status:' + '"' + $('[name="etat_listretour"]:checked').attr('data-value') + '"' : "" )
                /* = list*/ + ($('#date_debut_listretour').val() ? ',date_debut:' + '"' + $('#date_debut_listretour').val() + '"' : "" )
                /* = list*/ + ($('#date_fin_listretour').val() ? ',date_fin:' + '"' + $('#date_fin_listretour').val() + '"' : "" )
                /* = list*/ + ($('#created_at_start_listretour').val() ? ',created_at_start:' + '"' + $('#created_at_start_listretour').val() + '"' : "" )
                /* = list*/ + ($('#created_at_end_listretour').val() ? ',created_at_end:' + '"' + $('#created_at_end_listretour').val() + '"' : "" )
                +')';
            // blockUI_start_all('#section_listeclients');
            Init.getElementPaginated(rewriteelement, listofrequests_assoc["retours"]).then(function (data)
            {

                console.log(data);
                // pagination controls
                $scope.paginationretour = {
                    currentPage: data.metadata.current_page,
                    maxSize: 10,
                    entryLimit: $scope.paginationretour.entryLimit,
                    totalItems: data.metadata.total
                };
                // $scope.noOfPages_produit = data.metadata.last_page;
                $scope.retours = data.data;
            },function (msg)
            {

                toastr.error(msg);
            });
        }
        else if ( currentpage.indexOf('entreestock')!==-1 )
        {
            rewriteelement = 'entreestockspaginated(page:'+ $scope.paginationentreestock.currentPage +',count:'+ $scope.paginationentreestock.entryLimit
                + ($scope.userview ? ',user_id:' + $scope.userview.id : "" )
                + ($scope.medicamentview ? ',medicament_id:' + $scope.medicamentview.id : "" )
                + ($('#motif_listentreestock').val() ? ',motif_id:' + $('#motif_listentreestock').val() : "" )
                + ($('#user_listentreestock').val() ? ',user_id:' + $('#user_listentreestock').val() : "" )
                /* = list*/ + ($('#created_at_start_listentreestock').val() ? ',created_at_start:' + '"' + $('#created_at_start_listentreestock').val() + '"' : "" )
                /* = list*/ + ($('#created_at_end_listentreestock').val() ? ',created_at_end:' + '"' + $('#created_at_end_listentreestock').val() + '"' : "" )
                +')';
            // blockUI_start_all('#section_listeclients');
            Init.getElementPaginated(rewriteelement, listofrequests_assoc["entreestocks"]).then(function (data)
            {
                // blockUI_stop_all('#section_listeclients');
                console.log(data);
                // pagination controls
                $scope.paginationentreestock = {
                    currentPage: data.metadata.current_page,
                    maxSize: 10,
                    entryLimit: $scope.paginationentreestock.entryLimit,
                    totalItems: data.metadata.total
                };
                // $scope.noOfPages_produit = data.metadata.last_page;
                $scope.entreestocks = data.data;
            },function (msg)
            {
                // blockUI_stop_all('#section_listeclients');
                toastr.error(msg);
            });
        }
        else if ( currentpage.indexOf('inventaire')!==-1 )
        {
            rewriteelement = 'inventairespaginated(page:'+ $scope.paginationinventaire.currentPage +',count:'+ $scope.paginationinventaire.entryLimit
                + ($scope.userview ? ',user_id:' + $scope.userview.id : "" )
                + ($('#user_listinventaire').val() ? ',user_id:' + $('#user_listinventaire').val() : "" )
                + ($scope.medicamentview ? ',medicament_id:' + $scope.medicamentview.id : "" )
                + ($('#medicament_listinventaire').val() ? ',medicament_id:' + $('#medicament_listinventaire').val() : "" )
                /* = list*/ + ($('#created_at_start_listinventaire').val() ? ',created_at_start:' + '"' + $('#created_at_start_listinventaire').val() + '"' : "" )
                /* = list*/ + ($('#created_at_end_listinventaire').val() ? ',created_at_end:' + '"' + $('#created_at_end_listinventaire').val() + '"' : "" )
                +')';
            // blockUI_start_all('#section_listeclients');
            Init.getElementPaginated(rewriteelement, listofrequests_assoc["inventaires"]).then(function (data)
            {
                // blockUI_stop_all('#section_listeclients');
                console.log(data);
                // pagination controls
                $scope.paginationinventaire = {
                    currentPage: data.metadata.current_page,
                    maxSize: 10,
                    entryLimit: $scope.paginationinventaire.entryLimit,
                    totalItems: data.metadata.total
                };
                // $scope.noOfPages_produit = data.metadata.last_page;
                $scope.inventaires = data.data;
            },function (msg)
            {
                // blockUI_stop_all('#section_listeclients');
                toastr.error(msg);
            });
        }
        else if ( currentpage.indexOf('factureproforma')!==-1 )
        {
            rewriteelement = 'factureproformaspaginated(page:'+ $scope.paginationfactureproforma.currentPage +',count:'+ $scope.paginationfactureproforma.entryLimit
                + ($scope.fournisseurview ? ',fournisseur_id:' + $scope.fournisseurview.id : "" )
                + ($scope.userview ? ',user_id:' + $scope.userview.id : "" )
                + ($('#codefacture_listfactureproforma').val() ? ',code_facture:' + '"' + $('#codefacture_listfactureproforma').val() + '"' : "" )
                + ($('#fournisseur_listfactureproforma').val() ? ',fournisseur_id:' + $('#fournisseur_listfactureproforma').val() : "" )
                + ($('#user_listfactureproforma').val() ? ',user_id:' + $('#user_listfactureproforma').val() : "" )
                + ($('#created_at_start_listfactureproforma').val() ? ',created_at_start:' + '"' + $('#created_at_start_listfactureproforma').val() + '"' : "" )
                + ($('#created_at_end_listfactureproforma').val() ? ',created_at_end:' + '"' + $('#created_at_end_listfactureproforma').val() + '"' : "" )
                +')';
            // blockUI_start_all('#section_listeclients');
            Init.getElementPaginated(rewriteelement, listofrequests_assoc["factureproformas"]).then(function (data)
            {
                // blockUI_stop_all('#section_listeclients');
                // console.log('fac', data);
                // pagination controls
                $scope.paginationfactureproforma = {
                    currentPage: data.metadata.current_page,
                    maxSize: 10,
                    entryLimit: $scope.paginationfactureproforma.entryLimit,
                    totalItems: data.metadata.total
                };
                $scope.factureproformas = data.data;
                console.log($scope.factureproformas)
            },function (msg)
            {
                // blockUI_stop_all('#section_listeclients');
                toastr.error(msg);
            });
        }
        else if ( currentpage.indexOf('medicament')!==-1 )
        {
            var typemedicament_modal = null;
            $('.typemedicament_modal.filter').each(function(key, value){
                if ($(this).val())
                {
                    typemedicament_modal = $(this).val();
                }
            });

            var searchdesignationmed_modal = null;
            $('.searchdesignationmed_modal.filter').each(function(key, value){
                if ($(this).val())
                {
                    searchdesignationmed_modal = $(this).val();
                }
            });
            var searchcipmed_modal = null;
            $('.searchcipmed_modal.filter').each(function(key, value){
                if ($(this).val())
                {
                    searchcipmed_modal = $(this).val();
                }
            });

            console.log('searchcipmed_modal =', searchcipmed_modal, 'searchdesignationmed_modal = ', searchdesignationmed_modal);

            rewriteelement = 'medicamentspaginated(page:'+ $scope.paginationmedicament.currentPage +',count:'+ $scope.paginationmedicament.entryLimit
                + ($scope.boncommandeview ? ',bon_commande_id:' + $scope.boncommandeview.id : "" )
                + ($scope.factureproformaview ? ',facture_proforma_id:' + $scope.factureproformaview.id : "" )
                + (searchcipmed_modal ? (',cip:' + '"' + searchcipmed_modal + '"') : "" )
                + (searchdesignationmed_modal ? (',designation:' + '"' + searchdesignationmed_modal + '"') : "" )
                + ($('#searchtexte_listmedicament').val() ? (',' + $('#searchoption_listmedicament').val() + ':"' + $('#searchtexte_listmedicament').val() + '"') : "" )
                + ($('#designationmedicament_listmedicament').val() ? ',designation:"' + $('#designationmedicament_listmedicament').val() + '"' : "" )
                + ($('#typemedicament_listmedicament').val() ? ',type_medicament_id:' + $('#typemedicament_listmedicament').val() : "" )
                + ($('#famillemedicament_listmedicament').val() ? ',famille_medicament_id:' + $('#famillemedicament_listmedicament').val() : "" )
                + ($('#categoriemedicament_listmedicament').val() ? ',categorie_id:' + $('#categoriemedicament_listmedicament').val() : "" )
                + ($('#lettre_debut_listmedicament').val() ? ',letter_start:' + '"' + $('#lettre_debut_listmedicament').val() + '"' : "" )
                + ($('#lettre_fin_listmedicament').val() ? ',letter_end:' + '"' + $('#lettre_fin_listmedicament').val() + '"' : "" )
                +')';
            // blockUI_start_all('#section_listeclients');
            Init.getElementPaginated(rewriteelement, listofrequests_assoc["medicaments"]).then(function (data)
            {
                console.log(data);

                $scope.paginationmedicament = {
                    currentPage: data.metadata.current_page,
                    maxSize: 10,
                    entryLimit: $scope.paginationmedicament.entryLimit,
                    totalItems: data.metadata.total
                };
                $scope.medicaments = data.data;
            },function (msg)
            {
                toastr.error(msg);
            });
        }
        else if ( currentpage.indexOf('paiement')!==-1 )
        {
            rewriteelement = 'paiementspaginated(page:'+ $scope.paginationpaiement.currentPage +',count:'+ $scope.paginationpaiement.entryLimit
                + ($scope.abonnementview!=null ? ',abonnement_id:' + $scope.abonnementview.id : "" )
                + ($scope.userview ? ',user_id:' + $scope.userview.id : "" )
                /* = listpaiement*/ + ($('#mode_paiement_listpaiement').val() ? ',mode_paiement:' + '"' + $('#mode_paiement_listpaiement').val() + '"' : "" )
                /* = listpaiement*/ + ($('#abonnement_listpaiement').val() ? ',abonnement_id:' + $('#abonnement_listpaiement').val() : "" )
                /* = listpaiement*/ + ($('#numab_listpaiement').val() ? ',abonnement_id:' + $('#numab_listpaiement').val() : "" )
                /* = listpaiement*/ + ($('#created_at_start_listpaiement').val() ? ',created_at_start:' + '"' + $('#created_at_start_listpaiement').val() + '"' : "" )
                /* = listpaiement*/ + ($('#created_at_end_listpaiement').val() ? ',created_at_end:' + '"' + $('#created_at_end_listpaiement').val() + '"' : "" )
                +')';
            // blockUI_start_all('#section_listeclients');
            Init.getElementPaginated(rewriteelement, listofrequests_assoc["paiements"]).then(function (data)
            {
                // blockUI_stop_all('#section_listeclients');
                console.log('paiementspaginated', data);
                // pagination controls
                $scope.paginationpaiement = {
                    currentPage: data.metadata.current_page,
                    maxSize: 10,
                    entryLimit: $scope.paginationpaiement.entryLimit,
                    totalItems: data.metadata.total
                };
                $scope.paiements = data.data;

            },function (msg)
            {
                // blockUI_stop_all('#section_listeclients');
                toastr.error(msg);
            });
        }
        else if ( currentpage.indexOf('vente')!==-1 )
        {
            var searchclientvente_modal = null;
            $('.searchclientvente_modal.filter').each(function(key, value){
                if ($(this).val())
                {
                    searchclientvente_modal = $(this).val();
                }
            });

            var searchassurancevente_modal = null;
            $('.searchassurancevente_modal.filter').each(function(key, value){
                if ($(this).val())
                {
                    searchassurancevente_modal = $(this).val();
                }
            });

            console.log('searchclientvente_modal =', searchclientvente_modal, 'searchassurancevente_modal = ', searchassurancevente_modal);

            rewriteelement = 'ventespaginated(page:'+ $scope.paginationvente.currentPage +',count:'+ $scope.paginationvente.entryLimit
                + ($scope.userview ? ',user_id:' + $scope.userview.id : "" )
                + ($scope.caisseview ? ',caisse_id:' + $scope.caisseview.id : "" )
                + ($scope.clientview ? ',client_id:' + $scope.clientview.id : "" )
                + ($scope.a_recouvrer ? ',a_recouvrer:true' : "" )
                + ($scope.assuranceview ? ',assurance_id:' + $scope.assuranceview.id : "" )
                + ($scope.medicamentview ? ',medicament_id:' + $scope.medicamentview.id : "" )
                + (searchassurancevente_modal ? ',assurance_id:' + searchassurancevente_modal : "" )
                + (searchclientvente_modal ? ',client_id:' + searchclientvente_modal : "" )
                + ($('#searchtexte_vente').val() ? (',' + $('#searchoption_vente').val() + ':"' + $('#searchtexte_vente').val() + '"') : "" )
                + ($('#assurance_listvente').val() ? ',assurance_id:' + $('#assurance_listvente').val() : "" )
                + ($('#client_listvente').val() ? ',client_id:' + $('#client_listvente').val() : "" )
                + ($('#user_listvente').val() ? ',user_id:' + $('#user_listvente').val() : "" )
                + ($('#caisse_listvente').val() ? ',caisse_id:' + $('#caisse_listvente').val() : "" )
                + ($('[name="etat_listvente"]:checked').attr('data-value') ? ',etat_vente:' + '"' + $('[name="etat_listvente"]:checked').attr('data-value') + '"' : "" )
                + ($('#created_at_start_listvente').val() ? ',created_at_start:' + '"' + $('#created_at_start_listvente').val() + '"' : "" )
                + ($('#created_at_end_listvente').val() ? ',created_at_end:' + '"' + $('#created_at_end_listvente').val() + '"' : "" )
                +')';
            // blockUI_start_all('#section_listeclients');
            Init.getElementPaginated(rewriteelement, listofrequests_assoc["ventes"]).then(function (data)
            {
                // blockUI_stop_all('#section_listeclients');
                console.log('ventespaginated', data);
                // pagination controls
                $scope.paginationvente = {
                    currentPage: data.metadata.current_page,
                    maxSize: 10,
                    entryLimit: $scope.paginationvente.entryLimit,
                    totalItems: data.metadata.total
                };
                $scope.ventes = data.data;
            },function (msg)
            {
                toastr.error(msg);
            });
        }
        else if (currentpage.indexOf('role') !== -1)
        {
            rewriteelement = (currentpage + 's') + 'paginated(page:' + $scope.paginationrole.currentPage + ',count:' + $scope.paginationrole.entryLimit
                + ($('#search_listrole').val() ? (',search:"' + $('#search_listrole').val() + '"') : "")
                + ')';

            Init.getElementPaginated(rewriteelement, listofrequests_assoc[(currentpage + 's')]).then(function (data) {

                // console.log(data);
                // pagination controls
                $scope.paginationrole = {
                    currentPage: data.metadata.current_page,
                    maxSize: 10,
                    entryLimit: $scope.paginationrole.entryLimit,
                    totalItems: data.metadata.total
                };

                $scope.roles = data.data;

            }, function (msg) {

                toastr.error(msg);
            });

        }
        else if ( currentpage.indexOf('user')!==-1 )
        {
            rewriteelement = 'userspaginated(page:'+ $scope.paginationuser.currentPage +',count:'+ $scope.paginationuser.entryLimit
                + ($('#searchrole_user').val() ? ',role_id:' + $('#searchrole_user').val() : "" )
                + ($('#searchtexte_user').val() ? (',' + $('#searchoption_user').val() + ':"' + $('#searchtexte_user').val() + '"') : "" )
                +')';
            // blockUI_start_all('#section_listeclients');
            Init.getElementPaginated(rewriteelement, listofrequests_assoc["users"]).then(function (data)
            {
                // blockUI_stop_all('#section_listeclients');
                console.log(data);
                // pagination controls
                $scope.paginationuser = {
                    currentPage: data.metadata.current_page,
                    maxSize: 10,
                    entryLimit: $scope.paginationuser.entryLimit,
                    totalItems: data.metadata.total
                };
                // $scope.noOfPages_produit = data.metadata.last_page;
                $scope.users = data.data;
            },function (msg)
            {
                // blockUI_stop_all('#section_listeclients');
                toastr.error(msg);
            });
        }
    };


    $scope.OneBuffetAlReadySelected = true;
    // Permet d'ajouter une reservation à la liste des reservation d'une facture
    $scope.menu_consommations = [];
    $scope.addToMenu = function (event, itemId)
    {
        $scope.OneBuffetAlReadySelected = true;
        $scope.consommation_buffet_id = null;
        $scope.menu_consommations = [];
        $("[id^=consommation_menu]").each(function (key,value)
        {
            if ($(this).prop('checked'))
            {
                var consommation_id = Number($(this).attr('data-consommation-id'));
                $.each($scope.consommations, function (key, value) {
                    if (consommation_id==value.id && value.is_buffet)
                    {
                        $scope.OneBuffetAlReadySelected = false;
                        $scope.consommation_buffet_id = consommation_id;
                        /*$("[id^=consommation_menu]").each(function (keyUn,valueUn)
                        {
                            if(consommation_id!=Number($(this).attr('data-consommation-id')))
                            {
                                console.log('checked', $(this).prop('checked'));
                                $(this).prop('checked', false);
                                console.log('checked', $(this).prop('checked'));

                            }
                        })*/;
                        $scope.menu_consommations.push(consommation_id);
                    }
                });
                if ($scope.OneBuffetAlReadySelected)
                {
                    console.log($scope.OneBuffetAlReadySelected);
                    $scope.menu_consommations.push(consommation_id);
                }
            }
        });

        console.log('arrive menu', $scope.menu_consommations);
    };



    // Permet d'ajouter une permission à la liste des permissions d'un role
    $scope.role_permissions = [];
    $scope.addToRole = function (event, itemId)
    {
        var all_checked = true;
        $scope.role_permissions = [];
        $("[id^=permission_role]").each(function (key,value)
        {
            if ($(this).prop('checked'))
            {
                var permission_id = $(this).attr('data-permission-id');
                $scope.role_permissions.push(permission_id);
            }
            else
            {
                all_checked = false;
            }
        });
        $('#permission_all_role').prop('checked', all_checked);
        console.log('arrive', all_checked, $scope.role_permissions);
    };

    $scope.addToNotif = function (event, itemId)
    {
        $scope.liste_notif = [];
        $("[id^=notif]").each(function (key,value)
        {
            if ($(this).prop('checked'))
            {
                var medicament = $(this).attr('data-permission-id');
                var medoc =  angular.fromJson(medicament);
                $scope.liste_notif.push({
                    "id": medoc[0].id,
                    "medicament_id": medoc[0].id,
                    "designation": medoc[0].designation,
                    "qte_commande": medoc[1],
                    "prix_achat": medoc[0].prix_cession
                });
            }
        });
        console.log('arrive', $scope.liste_notif);
    };


    $scope.reInit = function(type="select2")
    {
        setTimeout(function () {

            if (type.indexOf("select2")!==-1)
            {
                $('.select2').select2({
                    width: 'resolve',
                    tags: true
                });
            }
            else if (type.indexOf("datedropper")!==-1)
            {
                $('.datedropper').pickadate({
                    format: 'dd/mm/yyyy',
                    formatSubmit: 'dd/mm/yyyy',
                    monthsFull: [ 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre' ],
                    monthsShort: [ 'Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec' ],
                    weekdaysShort: [ 'Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam' ],
                    today: 'aujourd\'hui',
                    clear: 'clair',
                    close: 'Fermer'
                });
            }
        },100);
    };

    $scope.panier = [];
    $scope.details_monnaie = [];
    //$scope.lignes_proforma = [];
    //$scope.lignes_livraison = [];
    //$scope.lignes_vente = [];
    $scope.panierAffile = [];
    $scope.addAffiles = function()
    {

        var nomAffile = $("#nomAffile_vente").val();
        $("#nomAffile_vente").val("")
        console.log("je suis la", nomAffile);
        console.log(nomAffile, $scope.panierAffile)

      $scope.panierAffile.push(
          {
              "nomcomplet": nomAffile
          }
      )
    };
    $scope.deleteAffile = function(key)
    {
        console.log("je suis la")
        let i = $scope.panierAffile.indexOf(key)
        $scope.panierAffile.splice(i, 1)
    }
    $scope.selectionlisteproduits = $scope.medicaments;

    $scope.addInCommande = function(event, from = 'commande', item, action=1)
    {
        console.log('from', from);
        if ($scope.commandeview && !$scope.commandeview.can_updated)
        {
            iziToast.info({
                message: "Cette vente n'est plus modifiable",
                position: 'topRight'
            });
            return ;
        }
        else
        {
            var add = true;
            $.each($scope.panier, function (key, value)
            {
                console.log('ici panier', from);

                if (Number(value.medicament_id) === Number(item.id))
                {
                    console.log('value', value);
                    if (action==0)
                    {
                        $scope.panier.splice(key,1);
                    }
                    else
                    {
                        if (from.indexOf('commande')!==-1)
                        {
                            $scope.panier[key].qte_commande+=action;
                            if ($scope.panier[key].qte_commande===0)
                            {
                                $scope.panier.splice(key,1);
                            }
                        }
                        else if (from.indexOf('livraison')!==-1)
                        {
                            $scope.panier[key].qte_livre+=action;
                            if ($scope.panier[key].qte_livre===0)
                            {
                                $scope.panier.splice(key,1);
                            }
                        }
                        else if (from.indexOf('inventaire')!==-1)
                        {
                            $scope.panier[key].qte_inventaire+=action;
                            if ($scope.panier[key].qte_inventaire===0)
                            {
                                $scope.panier.splice(key,1);
                            }
                        }
                        else if (from.indexOf('retour')!==-1)
                        {
                            $scope.panier[key].quantity+=action;
                            if ($scope.panier[key].quantity===0)
                            {
                                $scope.panier.splice(key,1);
                            }
                        }
                        else if (from.indexOf('factureproforma')!==-1)
                        {
                            $scope.panier[key].qte+=action;
                            if ($scope.panier[key].qte===0)
                            {
                                $scope.panier.splice(key,1);
                            }
                        }
                        else if (from.indexOf('vente')!==-1)
                        {
                            $scope.panier[key].qte_vendue+=action;
                            if ($scope.panier[key].qte_vendue===0)
                            {
                                $scope.panier.splice(key,1);
                            }
                        }
                        else if(from.indexOf('client')!==-1)
                        {
                            $scope.panier.nomcomplet+=action;
                        }
                    }
                    add = false;
                    //}
                }
                return add;
            });

            if (add)
            {
                if (from.indexOf('commande')!==-1)
                {
                    $scope.panier.push({"id":item.id, "medicament_id":item.id, "designation":item.designation, "qte_commande" : 1, "prix_achat":item.prix_cession});
                }
                else if (from.indexOf('livraison')!==-1)
                {
                    $scope.panier.push({"id":item.id, "medicament_id":item.id, "designation":item.designation, "tva":item.with_tva, "qte_livre" : 1, "qte_bonus" : 0, "prix_cession":item.prix_cession, "prix_public":item.prix_public});
                }
                else if (from.indexOf('inventaire')!==-1)
                {
                    $scope.panier.push({"id":item.id, "medicament_id":item.id, "designation":item.designation, "current_quantity":item.current_quantity, "qte_inventaire" : item.current_quantity});
                }

                else if (from.indexOf('retour')!==-1)
                {
                    $scope.panier.push({"id":item.id, "medicament_id":item.id, "designation":item.designation, "tva":item.with_tva, "quantity" : 1, "prix_cession":item.prix_cession});
                }
                else if (from.indexOf('fusion')!==-1)
                {
                    $scope.panier.push({"id":item.id, "medicament_id":item.id, "designation":item.designation, "prix_cession":item.prix_cession});
                    console.log($scope.panier);
                }
                else if (from.indexOf('factureproforma')!==-1)
                {
                    $scope.panier.push({"id":item.id,"medicament_id":item.id, "designation":item.designation, "qte" : 1, "prix_unitaire": item.prix_cession});
                }
                else if (from.indexOf('vente')!==-1)
                {
                    $scope.panier.push({"id":item.id,"medicament_id":item.id, "designation":item.designation, "qte_vendue" : 1, "tva" : item.with_tva, "prix_unitaire":item.prix_public});
                }
            }
        }
        if (from.indexOf('livraison')!==-1)
        {
            $scope.calculateTotal('bonlivraison');
        }
        else if (from.indexOf('vente')!==-1)
        {
            $scope.calculateTotal('vente');
        }
        else if (from.indexOf('retour')!==-1)
        {
            $scope.calculateTotal('retour');
        }
    };


    $scope.selectionVente = [];
    $scope.addVenteIn = function(event, from = 'recouvrement', item, action=1)
    {
        console.log('from', from);
            var add = true;
            $.each($scope.selectionVente, function (key, value)
            {
                console.log('ici selectionVente', from);

                if (Number(value.vente_id) === Number(item.id))
                {
                    console.log('value', value);
                    if (action==0)
                    {
                        $scope.selectionVente.splice(key,1);
                    }
                    else
                    {
                        if (from.indexOf('recouvrement')!==-1)
                        {
                            $scope.selectionVente[key].nb_click+=action;
                            if ($scope.selectionVente[key].nb_click===0)
                            {
                                $scope.selectionVente.splice(key,1);
                            }
                        }
                    }
                    add = false;
                    //}
                }
                return add;
            });

            if (add)
            {
                if (from.indexOf('recouvrement')!==-1)
                {
                    $scope.selectionVente.push({"id":item.id, "vente_id":item.id, "numero_ticket":item.numero_ticket, "total_ttc":item.total_ttc, "nb_click" : 1, "somme":0});
                }
            }
        if (from.indexOf('recouvrement')!==-1)
        {
            $scope.calculateTotal('recouvrement');
        }
    };

    $scope.actionStock = function(event, from = 'entree', item)
    {
        if (from.indexOf('entree') !== -1) {
            $('#medicament_entreestock').val(item.id);
            $('#nommedicament_entreestock').val(item.designation);
            console.log(item.id, item.designation);
        } else if (from.indexOf('sortie') !== -1) {
            $('#medicament_sortiestock').val(item.id);
            $('#nommedicament_sortiestock').val(item.designation);
        }else if (from.indexOf('detail') !== -1) {
            var cip = item.cip; var cip2 = item.cip2; var cip3 = item.cip3; var cip4 = item.cip4;
            var nom = item.designation;

            if (item.medicaments.length != 0) {

                var id_detail = item.medicaments[0].id;
                $('#id_detaillermedicament').val(id_detail);
                $('#nombre_tablette_detaillermedicament').val(item.medicaments[0].nombre_detail).attr("readonly", true);
                $('#prix_tablette_detaillermedicament').val(item.medicaments[0].prix_public).attr("readonly", true);

            }
            else {
                $('#id_detaillermedicament').val("");
                $('#nombre_tablette_detaillermedicament').val("").attr("readonly", false);
                $('#prix_tablette_detaillermedicament').val("").attr("readonly", false);

            }

            $('#nommedicament_detaillermedicament').val(item.designation);
            $('#designation_detaillermedicament').val(nom+'/DETAIL');
            $('#prix_cession_detaillermedicament').val(0);
            $('#medicament_id_detaillermedicament').val(item.id);
            $('#with_tva_detaillermedicament').val(item.with_tva);
            $('#noart_detaillermedicament').val(item.noart);
            $('#famille_medicament_detaillermedicament').val(item.famille_medicament_id);
            $('#type_medicament_detaillermedicament').val(item.type_medicament_id);
            $('#categorie_medicament_detaillermedicament').val(item.categorie_id);
            if (item.cip != null) {$('#cip_detaillermedicament').val(cip+'/detail')}
            if (item.cip2 != null) {$('#cip2_detaillermedicament').val(cip2+'/detail')}
            if (item.cip3 != null) {$('#cip3_detaillermedicament').val(cip3+'/detail')}
            if (item.cip4 != null) {$('#cip4_detaillermedicament').val(cip4+'/detail')}

        }
    };

    $scope.suggerer = function(type)
    {
        $scope.liste_suggeree = [];
        $scope.getelements('fournisseurs');
        if (type.indexOf('tout') !== -1) {

            $.each($scope.notifications, function (keyItem, valueItem) {
                $.each(valueItem[1], function (key, value) {
                    $scope.liste_suggeree.push({
                        "id": value[0].id,
                        "medicament_id": value[0].id,
                        "designation": value[0].designation,
                        "qte_commande": value[1],
                        "prix_achat": value[0].prix_cession
                    });
                });

            });

            $scope.panier = $scope.liste_suggeree;
            //console.log($scope.panier);
            setTimeout(function () {

                $("#modal_addboncommande").modal('show');

            }, 60);
        }
        else if(type.indexOf('liste') !== -1) {

            if ($scope.liste_notif.length==0)
            {
                iziToast.error({
                    title: "",
                    message: "Vous n'avez selectionner aucun médicament",
                    position: 'topRight'
                });
            }
            else {
                $scope.panier = $scope.liste_notif;
                setTimeout(function () {

                    $("#modal_addboncommande").modal('show');

                }, 60);
            }

        }
    };

    $scope.addInDetailsMonnaie = function(event)
    {

        var valeurMonnaie = 0;
        $.each($scope.monaies, function (keyItem, oneItem) {
            if (oneItem.id == $('#typemonnaie_cloture').val()) {
                valeurMonnaie = oneItem.valeur;
            }
        });

        $scope.details_monnaie.push({"id":$('#typemonnaie_cloture').val(),"monaie_id":$('#typemonnaie_cloture').val(),"nombre":$('#nombremonnaie_cloture').val(),"valeur":valeurMonnaie});

        $('#nombremonnaie_cloture').val("");
        $('#typemonnaie_cloture').val("");

        console.log('details_monnaie', $scope.details_monnaie);
    };

    /*$scope.addInProforma = function(event, item)
    {

        $scope.lignes_proforma.push({"id":item.id,"medicament_id":item.id, "designation":item.designation,"tva":item.tva, "qte" : 1,"remise" : 0, "prix_achat":item.prix_cession});


        console.log('Nos lignes de facture', $scope.lignes_proforma);
    };*/

    /*$scope.addInVente = function(event, item)
    {

        $scope.lignes_vente.push({"id":item.id,"medicament_id":item.id, "designation":item.designation, "qte_vendue" : 1, "prix_unitaire":item.prix_cession});


        console.log('Nos lignes de vente', $scope.lignes_vente);
    };*/

    /*$scope.addInLivraison = function(event, item)
    {

        $scope.lignes_livraison.push({"id":item.id,"medicament_id":item.id,"code":item.code, "designation":item.designation, "tva":item.tva, "qte_livre" : 1, "qte_bonus" : 0, "prix_vente":item.prix_cession});


        console.log('Nos lignes de livraison', $scope.lignes_livraison);
    };*/

    /*$scope.deleteFromLivraison = function (selectedItem = null) {
        //  console.log('Je suis dans delete');
        $.each($scope.lignes_livraison, function (keyItem, oneItem) {
            if (oneItem.id == selectedItem.id) {
                $scope.lignes_livraison.splice(keyItem, 1);
                return false;
            }
        });

        console.log('Nos lignes de livraison', $scope.lignes_livraison);

    };*/

    /*$scope.deleteFromVente = function (selectedItem = null) {
        //  console.log('Je suis dans delete');
        $.each($scope.lignes_vente, function (keyItem, oneItem)
        {
            if (oneItem.id == selectedItem.id) {
                $scope.lignes_vente.splice(keyItem, 1);
                return false;
            }
        });

        console.log('Nos lignes de vente', $scope.lignes_vente);
    };*/

    /*$scope.deleteFromCommande = function (selectedItem = null) {
        //  console.log('Je suis dans delete');
        $.each($scope.panier, function (keyItem, oneItem) {
            if (oneItem.id == selectedItem.id) {
                $scope.panier.splice(keyItem, 1);
                return false;
            }
        });

        console.log('Nos lignes de commande', $scope.panier);

    };*/

    $scope.deleteFromDetailsMonnaie = function (selectedItem = null) {
        //  console.log('Je suis dans delete');
        $.each($scope.details_monnaie, function (keyItem, oneItem) {
            if (oneItem.id == selectedItem.id) {
                $scope.details_monnaie.splice(keyItem, 1);
                return false;
            }
        });

        console.log('details_monnaie', $scope.details_monnaie);

    };

    $scope.seeChange = function()
    {
        console.log('categoriereservation_reservation', $scope.categoriereservation_reservation);
    };

    $scope.seeGratuite = function()
    {
        console.log('gratuite_planning', $scope.gratuite_planning);
    };

    $scope.seeDecompte = function()
    {
        console.log('decomptee_reservation', $scope.decomptee_reservation);
    };

    $scope.refreshSelect2 = function()
    {
        setTimeout(function ()
        {
            $('.select2').select2();
        },100);
    };

    // Pour detecter le changement des routes avec Angular
    $scope.linknav="/";
    $scope.currenttemplateurl = "";
    $scope.$on('$routeChangeStart', function(next, current)
    {
        $scope.currenttemplateurl = current.templateUrl;
        /******* Réintialisation de certaines valeurs *******/
        $scope.planview = null;






        $scope.pageUpload = false;
        $scope.pageDashboard = false;
        $scope.requetteTabMedicament = "";
        $scope.requeteEtatStock = "";
        $scope.requeteFournisseur = "";
        $scope.pageCurrent = null;
        $scope.clientview = null;
        $scope.userview = null;
        $scope.medicamentview = null;
        $scope.boncommandeview = null;
        $scope.factureproformaview = null;
        $scope.recouvrementview = null;
        $scope.caisseview = null;
        $scope.assuranceview = null;
        $scope.depenseview = null;
        $scope.fournisseurview = null;
       
        $scope.retourview = null;
        $scope.factureproforamview = null;
        $scope.a_recouvrer = false;


        // for pagination
        $scope.paginationcli = {
            currentPage: 1,
            maxSize: 10,
            entryLimit: 10,
            totalItems: 0
        };
        $scope.paginationfactureproforma = {
            currentPage: 1,
            maxSize: 10,
            entryLimit: 10,
            totalItems: 0
        };


        $scope.paginationmedicament = {
            currentPage: 1,
            maxSize: 10,
            entryLimit: 10,
            totalItems: 0
        };

        $scope.paginationcaisse = {
            currentPage: 1,
            maxSize: 10,
            entryLimit: 10,
            totalItems: 0
        };

        $scope.paginationassurance = {
            currentPage: 1,
            maxSize: 10,
            entryLimit: 10,
            totalItems: 0
        };
        $scope.paginationfournisseur = {
            currentPage: 1,
            maxSize: 10,
            entryLimit: 10,
            totalItems: 0
        };
        $scope.paginationboncommande = {
            currentPage: 1,
            maxSize: 10,
            entryLimit: 10,
            totalItems: 0
        };

        $scope.paginationinventaire = {
            currentPage: 1,
            maxSize: 10,
            entryLimit: 10,
            totalItems: 0
        };

        $scope.paginationbonlivraison = {
            currentPage: 1,
            maxSize: 10,
            entryLimit: 10,
            totalItems: 0
        };

        $scope.paginationuser = {
            currentPage: 1,
            maxSize: 10,
            entryLimit: 10,
            totalItems: 0
        };

        $scope.paginationrole = {
            currentPage: 1,
            maxSize: 10,
            entryLimit: 10,
            totalItems: 0
        };

        $scope.paginationversement = {
            currentPage: 1,
            maxSize: 10,
            entryLimit: 10,
            totalItems: 0
        };
        $scope.paginationdepense = {
            currentPage: 1,
            maxSize: 10,
            entryLimit: 10,
            totalItems: 0
        };

        $scope.paginationcloture = {
            currentPage: 1,
            maxSize: 10,
            entryLimit: 10,
            totalItems: 0
        };

        $scope.paginationsortiestock = {
            currentPage: 1,
            maxSize: 10,
            entryLimit: 10,
            totalItems: 0
        };

        $scope.paginationretour = {
            currentPage: 1,
            maxSize: 10,
            entryLimit: 10,
            totalItems: 0
        };

        $scope.paginationentreestock = {
            currentPage: 1,
            maxSize: 10,
            entryLimit: 10,
            totalItems: 0
        };

        /******* /Réintialisation de certaines valeurs *******/


        // Pour donner la posssiblité à un utilisateur connecté de modifier son profil
      /*  $scope.pageChanged("medicament");
        $scope.getelements("users");
        $scope.getelements("categories");
        //$scope.getelements("typemedicaments");
        $scope.getelements("famillemedicaments");
        //$scope.getelements("caisses");
        $scope.getelements("modepaiements");
        $scope.liste_notif = [];
*/

        // blockUI_start_all("#content");
        $scope.linknav =$location.path();
       // $scope.getelements("fournisseurs");
       $scope.getelements("roles");
       $scope.getelements("permissions");
     console.log("angular je suis la ",(angular.lowercase(current.templateUrl)))
     if(angular.lowercase(current.templateUrl).indexOf('list-plan')!==-1)
        {
            $scope.pageChanged("plan");  
        }
     else if(angular.lowercase(current.templateUrl).indexOf('list-a-confirme')!==-1)
        {
         $scope.getelements('clients');
         }
     else if(angular.lowercase(current.templateUrl).indexOf('list-demande')!==-1)
        {
         $scope.getelements('users');
         }
     else if(angular.lowercase(current.templateUrl).indexOf('list-demande-encour')!==-1)
        {
         $scope.getelements('users');
         }

     else if(angular.lowercase(current.templateUrl).indexOf('list-client')!==-1)
     {

        $scope.clientview = null;
        if(current.params.itemId)
        {
            var idElmtclient = current.params.itemId;
            setTimeout(function ()
            {
                Init.getStatElement('client', idElmtclient);
            },1000);

            var req = "clients";
            $scope.clientview = {};
            rewriteReq = req + "(id:" + current.params.itemId + ")";
            Init.getElement(rewriteReq, listofrequests_assoc[req]).then(function (data)
            {
                $scope.clientview = data[0];
                $scope.getelements("typeclients");


            },function (msg)
            {
                toastr.error(msg);
            });
        }
        else
        {
            $scope.getelements("typeclients");
            $scope.pageChanged('client');
        }
    }
    else if(angular.lowercase(current.templateUrl).indexOf('list-profil')!==-1)
    {
        $scope.getelements('permissions');
        $scope.getelements('roles');
        //$scope.pageChanged('role');
    }
    else if(angular.lowercase(current.templateUrl).indexOf('user')!==-1)
    {
        $scope.userview = null;
        if(current.params.itemId)
        {
            var req = "users";
            $scope.userview = {};
            rewriteReq = req + "(id:" + current.params.itemId + ")";
            Init.getElement(rewriteReq, listofrequests_assoc[req]).then(function (data)
            {
                $scope.userview = data[0];
                changeStatusForm('detailuser',true);

                console.log($scope.userview );
                console.log('userId', current.params.itemId);

                $scope.pageChanged('users');
            },function (msg)
            {
                toastr.error(msg);
            });
        }
        else
        {
            $scope.getelements('roles');
            $scope.pageChanged('user');
        }
    }
    });


    $scope.infosDahboardBy = null;
    $scope.getInfosDahboard = function(byType)
    {
        $scope.infosDahboardBy = byType;
        $scope.getelements('dashboards');
    };

    $scope.getRecettes = function(forType)
    {
        $scope.getelements('recettes');
        $scope.getelements(forType);
    };


    $scope.formatDate = function(str)
    {
        date = str.split('/');
        return date[2]+"-"+date[1]+"-"+date[0] ;
    };

    /*
    A SUPP
    $scope.changeTab = function()
    {
        // Demande à angularjs de rafraichir les elements concernés
        $('body').updatePolyfill();

    };*/


    $scope.$on('$routeChangeSuccess', function(next, current)
    {
        setTimeout(function ()
        {
            $('.select2').select2(
                {
                    width: 'resolve',
                    tags: true
                }
            );

            // Format options
            /*
                        $('.datedropper').pickadate({
                            format: 'dd/mm/yyyy',
                            formatSubmit: 'dd/mm/yyyy',
                            monthsFull: [ 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre' ],
                            monthsShort: [ 'Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec' ],
                            weekdaysShort: [ 'Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam' ],
                            today: 'aujourd\'hui',
                            clear: 'clair',
                            close: 'Fermer'
                        });
            */

        },1000);

        if (angular.lowercase(current.templateUrl).indexOf('-reservation')!==-1)
        {
            setTimeout(function ()
            {
                $('.select2').select2();
            },1000);
            if(angular.lowercase(current.templateUrl).indexOf('add-')!==-1)
            {
                //console.log('routechangé');

                // $('#email_' + type).val(item.email);
                // $('#telephone_' + type).val(item.telephone);
                // $('#type_client_' + type).val(item.type_client.id);
                // $('#adresse_' + type).val(item.adresse);
                // $('#commentaire_' + type).val(item.commentaire);

            }
        }


        // Pour détecter les changements
        $scope.client_reservation = null;
        setTimeout(function ()
        {
            // Pour désactiver tous les events sur le select
            $(".select2.professeur").off('change');

            $(".select2.professeur").on("change", function (e)
            {
                console.log('professeur click detecté');

                if($(this).attr('id')==="professeur_programme")
                {
                    $scope.item_id = $(this).val();
                    $scope.professeurSelected = null;
                    $.each($scope.professeurs, function (key, value)
                    {
                        if (value.id === $scope.item_id)
                        {
                            $scope.professeurSelected = value;
                            return false;
                        }
                    });
                    $scope.$apply();
                }
            });
        }, 500);

        setTimeout(function ()
        {
            // Pour désactiver tous les events sur le select
            $(".select2.professeur_pratique").off('change');

            $(".select2.professeur_pratique").on("change", function (e)
            {
                console.log('professeur_pratique detecté');
                //console.log($scope.professeurSelected);

                if($(this).attr('id')==="professeur_pratique_programme")
                {
                    $scope.itemSalle_id = $(this).val();
                    $scope.pratiqueSelected = null;
                    $.each($scope.professeurpratiques, function (key, value)
                    {
                        if (value.id === $scope.itemSalle_id)
                        {
                            // console.log($scope.itemSalle_id);
                            $scope.pratiqueSelected = value;
                            return false;
                        }
                    });
                    $scope.$apply();
                }
            });
        }, 500);

    });


    $scope.datatoggle=function (href,addclass)
    {
        $(href).attr('class').match(addclass) ? $(href).removeClass(addclass) : $(href).addClass(addclass);
    };

    // Cocher tous les checkbox / Décocher tous les checkbox
    $scope.checkAllOruncheckAll = function ()
    {
        var cocherOuNon = $scope.cocherTout;
        if (cocherOuNon == true)
        {
            //Tout doit etre coché
            $("#labelCocherTout").html('Tout décocher');
        }
        else
        {
            //Tout doit etre décoché
            $("#labelCocherTout").html('Tout cocher');
        }
        $('.mycheckbox').prop('checked', cocherOuNon);
        $scope.addToRole();
        console.log("Je suis dans check all ===>" + cocherOuNon);
    };

    // to randomly generate the password
    $scope.genererPasse = function(type)
    {
        var length = 8,
            charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
            passe = "";
        for (var i = 0, n = charset.length; i < length; ++i) {
            passe += charset.charAt(Math.floor(Math.random() * n));
        }
        console.log('random password', passe);
        $('#password_' + type).val(passe);
        $('#confirmpassword_' + type).val(passe);
    };


    $scope.eraseFile = function (idInput)
    {
        $('#' + idInput).val("");
        $('#erase_'+ idInput).val("yes");
        $('#aff' + idInput).attr('src',imgupload);
    };

    function emptyform(type)
    {
        let dfd = $.Deferred();
        $('.ws-number').val("");
        $("input[id$=" + type + "], textarea[id$=" + type + "], select[id$=" + type + "], button[id$=" + type + "]").each(function ()
        {
            $(this).val("");
            $(this).attr($(this).hasClass('btn') ? 'disabled' : 'readonly', false);
        });

        $('#img' + type)
            .val("");
        $('#affimg' + type).attr('src',imgupload);

        console.log('factureproformaview before', $scope.factureproformaview);
        if (type.indexOf('boncommande')!==-1)
        {
            // Si on se trouve sur la page détails d'une facture proforma, on ne doit pas mettre à null
            if(angular.lowercase($scope.currenttemplateurl).indexOf('listdetail-factureproforma')===-1)
            {
                $scope.factureproformaview = null;
            }
            console.log('factureproformaview after', $scope.factureproformaview);
        }

        return dfd.promise();
    }

    // Permet de changer le statut du formulaire a editable ou non
    function changeStatusForm(type, status, disabled=false)
    {
        var doIt = false;
        // Pour mettre tous les chamnps en lecture seule
        $("input[id$=_" + type + "], textarea[id$=_" + type + "], select[id$=_" + type + "], button[id$=_" + type + "]").each(function ()
        {
            doIt = ($(this).attr('id').indexOf('detailnumCH')===-1);
            if (doIt)
            {
                console.log($(this).hasClass('btn'));

                $(this).attr($(this).hasClass('btn') || disabled ? 'disabled' : 'readonly', status);

                if ($scope.reservationview && $(this).hasClass('staydisabled'))
                {
                    $(this).attr('readonly', true);
                }

            }
            else
            {
                if (type.indexOf('paiement')!==-1)
                {
                    $(this).attr($(this).hasClass('btn') || disabled ? 'disabled' : 'readonly', !$scope.reservationview.can_updated_numch);
                }
                else
                {
                    $(this).attr('readonly', !$scope.reservationview.can_updated_numch);
                }
            }
        });
    }


    $scope.localize_panier = null;

    //voir un détail de médicament

    $scope.detail = {'id':'', 'designation':'', 'prixP':'','stock':''};
    $scope.voirDetail = function (medicamentdetaille) {
        console.log('detail', medicamentdetaille);

        $scope.detail.id = medicamentdetaille.id;
        $scope.detail.designation = medicamentdetaille.designation;
        $scope.detail.prixP = medicamentdetaille.prix_public;
        $scope.detail.stock = medicamentdetaille.current_quantity;

        $("#modal_addvoirDetailProduit").modal('show');
    };

    // Permet d'afficher le formulaire
    $scope.showModalAdd = function (type, fromUpdate=false, assistedListe=false, ObjPassed = null)
    {
        // $scope.panier = [];
        $scope.fromUpdate = false;
        $scope.selectionlisteproduits = $scope.medicaments;

        $scope.addcommandeview = false;
        setTimeout(function ()
        {
            // On fait d'abord un destroy
            if (!$('select').data('select2')) {
                $('.select').select2('destroy');
            }
            // Souscription
            $('.select2').select2();
        },500);


        emptyform(type);
        if (type.indexOf('boncommande')!==-1)
        {
            if ( !($scope.localize_panier && $scope.localize_panier.indexOf('boncommande')!==-1) )
            {
                $scope.panier = [];
            }
            $scope.localize_panier = "boncommande";
            $('#fournisseur_' + type).attr("readonly", false);
            // Pour permettre de ne récupérer que les produits présents dans la facture proforma
            let updateDate = $q((resolve, reject) => {
                resolve([]);
            });

            updateDate.then(data => {
                $scope.factureproformaview = ObjPassed;
                if ($scope.factureproformaview)
                {
                    $('#fournisseur_' + type).val($scope.factureproformaview.fournisseur_id).attr("readonly", true);
                }
                $scope.pageChanged('medicament');
            });

            $scope.getelements('typemedicaments');
            $scope.getelements('famillemedicaments');

            if (!fromUpdate)
            {
                $scope.getelements("fournisseurs");
            }
        }
        else if (type.indexOf('cloture')!==-1)
        {
            $scope.details_monnaie = [];
            $scope.getelements('monaies');
        }
        else if (type.indexOf('bonlivraison')!==-1)
        {
            if ( !($scope.localize_panier && $scope.localize_panier.indexOf('bonlivraison')!==-1) )
            {
                $scope.panier = [];
            }
            $scope.localize_panier = "bonlivraison";
            $scope.getelements('typemedicaments');
            $scope.getelements('famillemedicaments');
            $scope.pageChanged('medicament');
        }
        else if (type.indexOf('retour')!==-1)
        {
            if ( !($scope.localize_panier && $scope.localize_panier.indexOf('retour')!==-1) )
            {
                $scope.panier = [];
            }
            $scope.localize_panier = "retour";
            $scope.pageChanged('medicament');
        }
        else if (type.indexOf('fusion')!==-1)
        {
            if ( !($scope.localize_panier && $scope.localize_panier.indexOf('fusion')!==-1) )
            {
                $scope.panier = [];
            }
            $scope.localize_panier = "fusion";
            $scope.pageChanged('medicament');
        }
        else if (type.indexOf('factureproforma')!==-1)
        {
            if ( !($scope.localize_panier && $scope.localize_panier.indexOf('factureproforma')!==-1) )
            {
                $scope.panier = [];
            }

            $scope.localize_panier = "factureproforma";
            $scope.getelements('typemedicaments');
            $scope.getelements('famillemedicaments');
            $scope.pageChanged('medicament');
        }
        else if (type.indexOf('vente')!==-1)
        {
            if ( !($scope.localize_panier && $scope.localize_panier.indexOf('vente')!==-1) )
            {
                $scope.panier = [];
            }
            $scope.total_ttc_vente = 0;
            $scope.tvaVt = 0;
            $scope.remiseVt = 0 ;
            $scope.partPayeur = 0 ;
            $scope.total_ht_vente = 0;
            $scope.total_verse = 0;
            $scope.net_Apaye = 0;
            $scope.monnaie = 0;

            $scope.localize_panier = "vente";
            $scope.addventeview = true;
            $scope.venteview = null;
            $scope.getelements('typemedicaments');
            $scope.getelements('famillemedicaments');
            $scope.pageChanged('medicament');

            // Lors de l'ajout d'une nouvelle vente, on peut prendre le temps de charger certaines listes
            if (!fromUpdate)
            {
                $scope.getelements('caisses');
                $scope.getelements('clients');
                $scope.getelements('assurances');
                $scope.getelements("modepaiements");
            }
        }
        else if (type.indexOf('inventaire')!==-1)
        {
            if ( !($scope.localize_panier && $scope.localize_panier.indexOf('inventaire')!==-1) )
            {
                $scope.panier = [];
            }
            $scope.localize_panier = "inventaire";
            $scope.pageChanged('medicament');
            if (!fromUpdate)
            {
            }
        }
        else if (type.indexOf('entreestock')!==-1)
        {
            $('#nommedicament_entreestock').attr("readonly", true);
        }
        else if (type.indexOf('sortiestock')!==-1)
        {
            $('#nommedicament_sortiestock').attr("readonly", true);
        }
        else if (type.indexOf('detaillermedicament')!==-1)
        {
            $('#nommedicament_detaillermedicament').attr("readonly", true);
            $('#designation_detaillermedicament').attr("readonly", true);
        }
        else if (type.indexOf('recouvrement')!==-1)
        {
            $('#client_recouvrement').on('change', function (e) {
                $scope.pageChanged("vente");
            });
            $('#assurance_recouvrement').on('change', function (e) {
                $scope.pageChanged("vente");
            });
            $scope.total_recouvre = 0;
        }
        else if (type.indexOf('role')!==-1)
        {
            $scope.roleview = null;
            $("[id^=permission_role]").each(function (key,value)
            {
                $(this).prop('checked', false);
            });
            $('#permission_all_role').prop('checked', false);
        }
        else if (type.indexOf('user')!==-1)
        {
            $scope.getelements('roles', null, true);
        }

        $("#modal_add"+type).modal('show');
    };


    $scope.reInitAtForLigne = function(type="appro")
    {
        if (type.indexOf('inventaire')!==-1)
        {
            setTimeout(function ()
            {
                // Pour désactiver tous les events sur le select
                //$(".select2.produit_appro").off('change');

                $(".select2.produit_inventaire").on("change", function (e)
                {
                    var produit_id = $(this).val();
                    var position = $(this).attr('data-ligne');

                    var doChange = true;
                    if ($scope.ligne_inventaires[position].medicament_id!=null && $scope.ligne_inventaires[position].medicament_id==produit_id)
                    {
                        doChange = false;
                    }
                    $scope.ligne_inventaires[position].medicament_id = produit_id;
                    var found = false;
                    $.each($scope.medicaments, function (keyItem, valueItem)
                    {
                        if (valueItem.id==produit_id)
                        {
                            if (doChange)
                            {
                                $scope.ligne_inventaires[position].qte_app = valueItem.current_quantity;
                            }
                            found = true;
                        }
                        return !found;
                    });
                    $scope.$apply();

                    console.log('ligne_inventaires', $scope.ligne_inventaires);
                });

            }, 500);
        }
        else if (type.indexOf('regularisation')!==-1)
        {
            setTimeout(function ()
            {
                console.log("dans la regularisation");
                $(".select2.ligneinventaire_regularisation").on("change", function (e)
                {
                    console.log('ligneinventaire click detecté');
                    var item_id = $(this).val();
                    var data_ligne = $(this).attr('data-ligne');
                    $scope.ligne_regularisations[data_ligne].ligne_inventaire_id = item_id;

                    var found = false;
                    $.each($scope.ligneinventaires, function (keyItem, valueItem)
                    {
                        if (valueItem.id==item_id)
                        {
                            $scope.ligne_regularisations[data_ligne].actual_quantity = valueItem.actual_quantity;
                            $scope.ligne_regularisations[data_ligne].current_quantity = valueItem.current_quantity;
                            found = true;
                        }
                        return !found;
                    });

                    $scope.$apply();

                    console.log('$scope.ligne_regularisations', $scope.ligne_regularisations);
                });
            }, 500);
        }


    };

    $scope.chstat = {'id':'', 'statut':'', 'type':'', 'title':''};
    $scope.showModalStatut = function(event,type, statut, obj= null, title = null)
    {
        var id = 0;
        id = obj.id;
        $scope.chstat.id = id;
        $scope.chstat.statut = statut;
        $scope.chstat.type = type;
        $scope.chstat.title = title;

        emptyform('chstat');
        $("#modal_addchstat").modal('show');
    };


    $scope.facturegeneree = {'id':''};
    $scope.facture = function(event, obj= null)
    {
        $scope.facturegeneree.id = obj;

        emptyform('factureGeneree');
        $("#modal_addfactureGeneree").modal('show');
        $('#vente_facturee').val($scope.facturegeneree.id);
    };


    //TODO: définir l\'etat d'une reservation
    // implémenter toutes les variations du formulaire

    $scope.changeStatut = function(e, type)
    {
        var form = $('#form_addchstat');
        var send_data = {id: $scope.chstat.id, etat:$scope.chstat.statut, commentaire: $('#commentaire_chstat').val()};
        form.parent().parent().blockUI_start();
        Init.changeStatut(type, send_data).then(function(data)
        {
            form.parent().parent().blockUI_stop();
            if (data.data!=null && !data.errors)
            {
                if (type.indexOf('user')!==-1)
                {
                    var found = false;
                    $.each($scope.users, function (keyItem, valueItem)
                    {
                        if (valueItem.id==send_data.id)
                        {
                            $scope.users[keyItem].active = $scope.chstat.statut==0 ? false : true;
                            found = true;
                        }
                        return !found;
                    });
                }
                if (type.indexOf('retour')!==-1)
                {
                    var found = false;
                    $.each($scope.retours, function (keyItem, valueItem)
                    {
                        if (valueItem.id==send_data.id)
                        {
                            $scope.retours[keyItem].status = $scope.chstat.statut==0 ? false : true;
                            found = true;
                        }
                        return !found;
                    });
                }

                iziToast.success({
                    title: (!send_data.id ? 'AJOUT' : 'MODIFICATION'),
                    message: "succès",
                    position: 'topRight'
                });
                $("#modal_addchstat").modal('hide');
            }
            else
            {
                iziToast.error({
                    title: "",
                    message: '<span class="h4">' + data.errors + '</span>',
                    position: 'topRight'
                });
            }
        }, function (msg)
        {
            form.parent().parent().blockUI_stop();
            iziToast.error({
                message: '<span class="h4">' + msg + '</span>',
                position: 'topRight'
            });
        });
        console.log(type,'current status', $scope.chstat);
    };

    $scope.facturerVente = function(e)
    {
        console.log('arrive ici');
        e.preventDefault();

        var form = $('#form_addfactureGeneree');

        var formdata=(window.FormData) ? ( new FormData(form[0])): null;
        var send_data=(formdata!==null) ? formdata : form.serialize();

        // A ne pas supprimer
        send_dataObj = form.serializeObject();
        console.log('est tu la fichier????',send_dataObj, send_data);
        continuer = true;

            send_data.append("vente", $('#vente_facturee').val());
            send_data.append("nom_client", $('#nom_client_facture').val());
            send_data.append("telephone", $('#telephone_facture').val());

        if (form.validate() && continuer)
        {
            form.parent().parent().blockUI_start();
            Init.facturerVente(send_data).then(function(data)
            {
                form.parent().parent().blockUI_stop();
                if (data!=null)
                {
                    console.log(data);

                    $("#modal_addfactureGeneree").modal('hide');
                    var urlFacture = BASE_URL+ '/vente/redirectFacture/'+data+'';
                    var fact = window.open(urlFacture, '_blank');
                    fact.focus();

                }
            }, function (msg)
            {
                form.parent().parent().blockUI_stop();
                iziToast.error({
                    message: '<span class="h4">' + msg + '</span>',
                    position: 'topRight'
                });
                console.log('Erreur serveur ici = ' + msg);
            });

        }
    };


    $scope.donneesReservation = {'message':'', 'clientId':null, 'planningId':'', 'type':''};

    // automatically open the ticket page
    $scope.openTicket = function(idItem)
    {
        var urlTicket = BASE_URL+ '/vente-ticket/'+idItem+'';
        var ticket = window.open(urlTicket, '_blank');
        ticket.focus();
    };

    // Add element in database and in scope
    $scope.addElement = function(e,type,from='modal')
    {

        console.log('arrive ici');
        e.preventDefault();

        var form = $('#form_add' + type);

        var formdata=(window.FormData) ? ( new FormData(form[0])): null;
        var send_data=(formdata!==null) ? formdata : form.serialize();
        //console.log($scope.panierAffile, "je sui pas la mais la");

        // A ne pas supprimer
        send_dataObj = form.serializeObject();
        console.log('send_dataObj', $('#id_' + type).val(), send_dataObj, send_data);

        continuer = true;

        if (type.indexOf('role')!==-1)
        {
            send_data.append("permissions", $scope.role_permissions);
            console.log('role_permissions', $scope.role_permissions, '...', send_data.get('role_permissions') );
            if ($scope.role_permissions.length==0)
            {
                iziToast.error({
                    title: "",
                    message: "Vous devez ajouter au moins une permission au présent role",
                    position: 'topRight'
                });
                continuer = false;
            }
        }
        else if (type.indexOf('recouvrement')!==-1)
        {
            send_data.append("ventes", JSON.stringify($scope.selectionVente));
            send_data.append("montant_verse", $scope.total_recouvre);
            if ($scope.selectionVente.length==0)
            {
                iziToast.error({
                    title: "",
                    message: "Vous devez ajouter au moins une vente à recouvrer",
                    position: 'topRight'
                });
                continuer = false;
            }
        }
        else if (type.indexOf('boncommande')!==-1)
        {
            send_data.append("ligne_commandes", JSON.stringify($scope.panier));
            if ($scope.panier.length==0)
            {
                iziToast.error({
                    title: "",
                    message: "Il faut au moins une ligne de commande",
                    position: 'topRight'
                });
                continuer = false;
            }

            if ($scope.factureproformaview)
            {
                // On ajoute la propriété de la facture proforma
                send_data.append("facture_proforma", $scope.factureproformaview.id);
            }
        }
        else if (type.indexOf('cloture')!==-1)
        {
            send_data.append("detail_monaies", JSON.stringify($scope.details_monnaie));
         /*   if ($scope.details_monnaie.length==0)
            {
                iziToast.error({
                    title: "",
                    message: "Il faut au moins une ligne pour les types de monnaie",
                    position: 'topRight'
                });
                continuer = false;
            }*/
        }
        else if (type.indexOf('factureproforma')!==-1)
        {
            send_data.append("ligne_factures", JSON.stringify($scope.panier));
            if ($scope.panier.length==0)
            {
                iziToast.error({
                    title: "",
                    message: "Il faut au moins une ligne sur la facture",
                    position: 'topRight'
                });
                continuer = false;
            }
        }
        else if (type.indexOf('bonlivraison')!==-1)
        {
            if ($scope.boncommandeview)
            {
                send_data.set("bon_commande_id", $scope.boncommandeview.id);
            }

            send_data.append("ligne_livraison", JSON.stringify($scope.panier));
            if ($scope.panier.length==0)
            {
                iziToast.error({
                    title: "",
                    message: "Il faut au moins une ligne de livraison",
                    position: 'topRight'
                });
                continuer = false;

            }
        }
        else if (type.indexOf('retour')!==-1)
        {
            send_data.append("ligne_retours", JSON.stringify($scope.panier));
            if ($scope.panier.length==0)
            {
                iziToast.error({
                    title: "",
                    message: "Il faut au moins un produit pour le retour",
                    position: 'topRight'
                });
                continuer = false;

            }
        }
        else if (type.indexOf('vente')!==-1)
        {
            send_data.append("ligne_ventes", JSON.stringify($scope.panier));
            if ($scope.panier.length==0)
            {
                iziToast.error({
                    title: "",
                    message: "Il faut au moins une ligne de vente",
                    position: 'topRight'
                });
                continuer = false;
            }
        }
        else if (type.indexOf('client')!==-1)
        {
            if ($scope.panierAffile != [])
            {
                send_data.append("ligne_affile", JSON.stringify($scope.panierAffile));
            }
            // if ($scope.panier.length==0)
            // {
            //     iziToast.error({
            //         title: "",
            //         message: "Il faut au moins une ligne de vente",
            //         position: 'topRight'
            //     });
            //     continuer = false;
            // }
        }

        else if (type.indexOf('inventaire')!==-1)
        {
            send_data.append("details_inventaire", JSON.stringify($scope.panier));
            if ($scope.panier.length==0)
            {
                iziToast.error({
                    title: "",
                    message: "Il faut au moins une ligne d'inventaire",
                    position: 'topRight'
                });
                continuer = false;
            }
        }

        if (form.validate() && continuer)
        {
            form.parent().parent().blockUI_start();
            Init.saveElementAjax(type, send_data).then(function(data)
            {
                console.log('data retour', data);
                form.parent().parent().blockUI_stop();
                if (data.data!=null && !data.errors)
                {
                    emptyform(type);
                    getObj = data['data'][type + 's'][0];

                    if (type.indexOf('caisse')!==-1)
                    {
                        if (!send_dataObj.id)
                        {
                            $scope.caisses.push(getObj);
                        }
                        else
                        {
                            $.each($scope.caisses, function (keyItem, oneItem)
                            {
                                if (oneItem.id===getObj.id)
                                {
                                    $scope.caisses[keyItem] = getObj;
                                    return false;
                                }
                            });
                        }
                    }
                    else if (type.indexOf('depense')!==-1)
                    {
                        if (!send_dataObj.id)
                        {
                            $scope.depenses.push(getObj);
                            $scope.paginationdepense.totalItems++;
                            if($scope.depenses.length > $scope.paginationdepense.entryLimit)
                            {
                                $scope.pageChanged('depense');
                            }
                        }
                        else
                        {
                            $.each($scope.depenses, function (keyItem, oneItem)
                            {
                                if (oneItem.id===getObj.id)
                                {
                                    $scope.depenses[keyItem] = getObj;
                                    return false;
                                }
                            });
                        }
                    }
                    else if (type.indexOf('typeclient')!==-1)
                    {
                        if (!send_dataObj.id)
                        {
                            $scope.typeclients.push(getObj);
                            console.log($scope.typeclients);
                        }
                        else
                        {
                            $.each($scope.typeclients, function (keyItem, oneItem)
                            {
                                if (oneItem.id===getObj.id)
                                {
                                    $scope.typeclients[keyItem] = getObj;
                                    return false;
                                }
                            });
                        }
                    }
                    else if (type.indexOf('client')!==-1)
                    {
                        console.log('from', from);
                        if (from.indexOf('modal')===-1)
                        {

                            $location.path('list-client');
                        }
                        else
                        {
                            if (!send_dataObj.id)
                            {

                                $scope.clients.push(getObj);
                                $scope.paginationcli.totalItems++;
                                if($scope.clients.length > $scope.paginationcli.entryLimit)
                                {
                                    $scope.getelements('typeclients');
                                    $scope.getelements("zonelivraisons");
                                    $scope.pageChanged('client');
                                    $scope.getelements("assurances");
                                }
                            }
                            else
                            {
                                if ($scope.clientview && $scope.clientview.id===getObj.id)
                                {
                                    $scope.clientview = getObj;
                                }

                                $.each($scope.clients, function (keyItem, oneItem)
                                {
                                    if (oneItem.id===getObj.id)
                                    {
                                        $scope.clients[keyItem] = getObj;
                                        return false;
                                    }
                                });
                            }
                        }
                    }
                    else if (type.indexOf('typemedicament')!==-1)
                    {
                        if (!send_dataObj.id)
                        {
                            $scope.typemedicaments.push(getObj);
                        }
                        else
                        {
                            $.each($scope.typemedicaments, function (keyItem, oneItem)
                            {
                                if (oneItem.id===getObj.id)
                                {
                                    $scope.typemedicaments[keyItem] = getObj;
                                    return false;
                                }
                            });
                        }
                    }
                    else if (type.indexOf('typemotif')!==-1)
                    {
                        if (!send_dataObj.id)
                        {
                            $scope.typemotifs.push(getObj);
                        }
                        else
                        {
                            $.each($scope.typemotifs, function (keyItem, oneItem)
                            {
                                if (oneItem.id===getObj.id)
                                {
                                    $scope.typemotifs[keyItem] = getObj;
                                    return false;
                                }
                            });
                        }
                    }
                    else if (type.indexOf('motif')!==-1)
                    {
                        if (!send_dataObj.id)
                        {
                            $scope.motifs.push(getObj);
                        }
                        else
                        {
                            $.each($scope.motifs, function (keyItem, oneItem)
                            {
                                if (oneItem.id===getObj.id)
                                {
                                    $scope.motifs[keyItem] = getObj;
                                    return false;
                                }
                            });
                        }
                    }
                    else if (type.indexOf('famillemedicament')!==-1)
                    {
                        if (!send_dataObj.id)
                        {
                            $scope.famillemedicaments.push(getObj);
                        }
                        else
                        {
                            $.each($scope.famillemedicaments, function (keyItem, oneItem)
                            {
                                if (oneItem.id===getObj.id)
                                {
                                    $scope.famillemedicaments[keyItem] = getObj;
                                    return false;
                                }
                            });
                        }
                    }
                    else if (type.indexOf('categorie')!==-1)
                    {
                        if (!send_dataObj.id)
                        {
                            $scope.categories.push(getObj);
                        }
                        else
                        {
                            $.each($scope.categories, function (keyItem, oneItem)
                            {
                                if (oneItem.id===getObj.id)
                                {
                                    $scope.categories[keyItem] = getObj;
                                    return false;
                                }
                            });
                        }
                    }
                    else if (type.indexOf('zonelivraison')!==-1)
                    {
                        if (!send_dataObj.id)
                        {
                            $scope.zonelivraisons.push(getObj);
                        }
                        else
                        {
                            $.each($scope.zonelivraisons, function (keyItem, oneItem)
                            {
                                if (oneItem.id===getObj.id)
                                {
                                    $scope.zonelivraisons[keyItem] = getObj;
                                    return false;
                                }
                            });
                        }
                    }
                    else if (type.indexOf('sortiestock')!==-1)
                    {
                        $scope.pageChanged('sortiestock');
                    }
                    else if (type.indexOf('retour')!==-1)
                    {
                        $scope.pageChanged('retour');
                    }
                    else if (type.indexOf('entreestock')!==-1)
                    {
                        $scope.pageChanged('entreestock');
                    }
                    else if (type.indexOf('inventaire')!==-1)
                    {
                        if (!send_dataObj.id)
                        {
                            $scope.inventaires.splice(0,0,getObj);
                            $scope.paginationinventaire.totalItems++;
                            if($scope.inventaires.length > $scope.paginationinventaire.entryLimit)
                            {
                                $scope.pageChanged('inventaire');
                            }
                        }
                        else
                        {
                            $.each($scope.inventaires, function (keyItem, oneItem)
                            {
                                if (oneItem.id===getObj.id)
                                {
                                    $scope.inventaires[keyItem] = getObj;
                                    return false;
                                }
                            });
                        }
                    }
                    else if (type.indexOf('cloture')!==-1)
                    {
                        if (!send_dataObj.id)
                        {
                            $scope.clotures.push(getObj);
                            $scope.paginationcloture.totalItems++;
                            if($scope.clotures.length > $scope.paginationcloture.entryLimit)
                            {
                                $scope.pageChanged('cloture');
                            }
                        }
                        else
                        {
                            $.each($scope.clotures, function (keyItem, oneItem)
                            {
                                if (oneItem.id===getObj.id)
                                {
                                    $scope.clotures[keyItem] = getObj;
                                    return false;
                                }
                            });
                        }
                    }
                    else if (type.indexOf('versement')!==-1)
                    {
                        if (!send_dataObj.id)
                        {
                            $scope.versements.push(getObj);
                            $scope.paginationversement.totalItems++;
                            if($scope.versements.length > $scope.paginationversement.entryLimit)
                            {
                                $scope.pageChanged('versement');
                                $scope.getelements('modepaiements');
                                console.log($scope.modepaiements);

                            }
                        }
                        else
                        {
                            $.each($scope.versements, function (keyItem, oneItem)
                            {
                                if (oneItem.id===getObj.id)
                                {
                                    $scope.versements[keyItem] = getObj;
                                    return false;
                                }
                            });
                        }
                    }
                    else if (type.indexOf('assurance')!==-1)
                    {
                        if (!send_dataObj.id)
                        {
                            $scope.assurances.push(getObj);
                            $scope.paginationassurance.totalItems++;
                            if($scope.assurances.length > $scope.paginationassurance.entryLimit)
                            {
                                $scope.pageChanged('assurance');
                            }
                        }
                        else
                        {
                            if ($scope.assuranceview && $scope.assuranceview.id===getObj.id)
                            {
                                $scope.assuranceview = getObj;
                            }

                            $.each($scope.assurances, function (keyItem, oneItem)
                            {
                                if (oneItem.id===getObj.id)
                                {
                                    $scope.assurances[keyItem] = getObj;
                                    return false;
                                }
                            });
                        }
                    }
                    else if (type.indexOf('fournisseur')!==-1)
                    {
                        if (!send_dataObj.id)
                        {
                            $scope.fournisseurs.push(getObj);
                            $scope.paginationfournisseur.totalItems++;
                            if($scope.fournisseurs.length > $scope.paginationfournisseur.entryLimit)
                            {
                                $scope.pageChanged('fournisseur');
                            }
                        }
                        else
                        {
                            if ($scope.fournisseurview && $scope.fournisseurview.id===getObj.id)
                            {
                                $scope.fournisseurview = getObj;
                            }

                            $.each($scope.fournisseurs, function (keyItem, oneItem)
                            {
                                if (oneItem.id===getObj.id)
                                {
                                    $scope.fournisseurs[keyItem] = getObj;
                                    return false;
                                }
                            });
                        }
                    }
                    else if (type.indexOf('recouvrement')!==-1)
                    {
                        if (!send_dataObj.id)
                        {
                            $scope.recouvrements.push(getObj);
                            $scope.paginationrecouvrement.totalItems++;
                            if($scope.recouvrements.length > $scope.paginationrecouvrement.entryLimit)
                            {
                                $scope.pageChanged('recouvrement');
                            }
                        }
                        else
                        {
                            if ($scope.recouvrementview && $scope.recouvrementview.id===getObj.id)
                            {
                                $scope.recouvrementview = getObj;
                            }

                            $.each($scope.recouvrements, function (keyItem, oneItem)
                            {
                                if (oneItem.id===getObj.id)
                                {
                                    $scope.recouvrements[keyItem] = getObj;
                                    return false;
                                }
                            });
                        }
                    }
                    else if (type.indexOf('paiement')!==-1)
                    {
                        if ($scope.abonnementview)
                        {
                            $scope.abonnementview.left_to_pay = getObj.restant;
                        }
                        $scope.pageChanged('paiement');
                    }
                    else if (type.indexOf('medicament')!==-1)
                    {
                        if (!send_dataObj.id)
                        {
                            $scope.medicaments.splice(0,0,getObj);
                            $scope.paginationmedicament.totalItems++;
                            if($scope.medicaments.length > $scope.paginationmedicament.entryLimit)
                            {
                                $scope.pageChanged('medicament');
                            }
                        }
                        else
                        {
                            if ($scope.medicamentview && $scope.medicamentview.id===getObj.id)
                            {
                                $scope.medicamentview = getObj;
                                //location.reload();
                            }

                            $.each($scope.medicaments, function (keyItem, oneItem)
                            {
                                if (oneItem.id===getObj.id)
                                {
                                    $scope.medicaments[keyItem] = getObj;
                                    return false;
                                }
                            });
                        }
                    }
                    else if (type.indexOf('vente')!==-1)
                    {
                        if (!send_dataObj.id)
                        {
                            $scope.ventes.push(getObj);
                            $scope.paginationvente.totalItems++;
                            if($scope.ventes.length > $scope.paginationvente.entryLimit)
                            {
                                $scope.pageChanged('vente');
                            }
                        }
                        else
                        {
                            $.each($scope.ventes, function (keyItem, oneItem)
                            {
                                if (oneItem.id===getObj.id)
                                {
                                    $scope.ventes[keyItem] = getObj;
                                    return false;
                                }
                            });
                        }
                    }
                    else if (type.indexOf('boncommande')!==-1)
                    {
                        if (!send_dataObj.id)
                        {
                            $scope.boncommandes.splice(0,0,getObj);
                            $scope.paginationboncommande.totalItems++;
                            if($scope.boncommandes.length > $scope.paginationboncommande.entryLimit)
                            {
                                $scope.pageChanged('boncommande');
                            }
                        }
                        else
                        {
                            if ($scope.boncommandeview && $scope.boncommandeview.id===getObj.id)
                            {
                                $scope.boncommandeview = getObj;
                                //location.reload();
                            }

                            $.each($scope.boncommandes, function (keyItem, oneItem)
                            {
                                if (oneItem.id===getObj.id)
                                {
                                    $scope.boncommandes[keyItem] = getObj;
                                    return false;
                                }
                            });
                        }
                    }
                    else if (type.indexOf('factureproforma')!==-1)
                    {
                        if (!send_dataObj.id)
                        {
                            $scope.factureproformas.push(getObj);
                            $scope.paginationfactureproforma.totalItems++;
                            if($scope.factureproformas.length > $scope.paginationfactureproforma.entryLimit)
                            {
                                $scope.pageChanged('factureproforma');
                            }
                        }
                        else
                        {
                            $.each($scope.factureproformas, function (keyItem, oneItem)
                            {
                                if (oneItem.id===getObj.id)
                                {
                                    $scope.factureproformas[keyItem] = getObj;
                                    return false;
                                }
                            });
                        }
                    }
                    else if (type.indexOf('bonlivraison')!==-1)
                    {
                        // Dans le cas, où l'on se trouve sur la page de détails d'un bon de commande
                        if ($scope.boncommandeview && $scope.boncommandeview.id===getObj.bon_commande_id)
                        {
                            $scope.boncommandeview = getObj.bon_commande;
                            //location.reload();
                        }

                        if (!send_dataObj.id)
                        {
                            $scope.bonlivraisons.push(getObj);
                            $scope.paginationbonlivraison.totalItems++;
                            if($scope.bonlivraisons.length > $scope.paginationbonlivraison.entryLimit)
                            {
                                $scope.pageChanged('bonlivraison');
                            }
                        }
                        else
                        {
                            $.each($scope.bonlivraisons, function (keyItem, oneItem)
                            {
                                if (oneItem.id===getObj.id)
                                {
                                    $scope.bonlivraisons[keyItem] = getObj;
                                    return false;
                                }
                            });
                        }
                    }
                    else if (type.indexOf('role')!==-1)
                    {
                        if (!send_dataObj.id)
                        {
                            $scope.roles.push(getObj);
                        }
                        else
                        {
                            $.each($scope.roles, function (keyItem, oneItem)
                            {
                                if (oneItem.id===getObj.id)
                                {
                                    $scope.roles[keyItem] = getObj;
                                    return false;
                                }
                            });
                        }
                    }
                    else if (type.indexOf('user')!==-1)
                    {
                        if (!send_dataObj.id)
                        {
                            $scope.users.push(getObj);
                            $scope.paginationuser.totalItems++;
                            if($scope.users.length > $scope.paginationuser.entryLimit)
                            {
                                $scope.pageChanged('user');
                            }
                        }
                        else
                        {
                            location.reload();
                            $.each($scope.users, function (keyItem, oneItem)
                            {
                                if (oneItem.id===getObj.id)
                                {
                                    $scope.users[keyItem] = getObj;
                                    return false;
                                }
                            });
                        }
                    }

                    iziToast.success({
                        title: (!send_dataObj.id ? 'AJOUT' : 'MODIFICATION'),
                        message: "succès",
                        position: 'topRight'
                    });
                    $("#modal_add" + type).modal('hide');

                    if (type.indexOf('vente')!==-1)
                    {
                        $scope.openTicket(getObj.id);
                    }

                    // Soit pour une entrée de stock / sortie de stock
                    if (type.indexOf('stock')!==-1)
                    {
                        $scope.getelements('medicaments');
                    }

                    // Dans tous les cas, on réinitiliase
                    $scope.localize_panier = null;

                }
                else
                {
                    iziToast.error({
                        title: "",
                        message: '<span class="h4">' + data.errors + '</span>',
                        position: 'topRight'
                    });
                }
            }, function (msg)
            {
                form.parent().parent().blockUI_stop();
                iziToast.error({
                    title: (!send_data.id ? 'AJOUT' : 'MODIFICATION'),
                    message: '<span class="h4">Erreur depuis le serveur, veuillez contactez l\'administrateur</span>',
                    position: 'topRight'
                });
                console.log('Erreur serveur ici = ' + msg);
            });
        }
    };
    $scope.addTabElements = function(e,type,from='modal')
    {
        console.log('arrive ici');
        e.preventDefault();

        var form = $('#form_addliste' + type);

        var formdata=(window.FormData) ? ( new FormData(form[0])): null;
        var send_data=(formdata!==null) ? formdata : form.serialize();

        // A ne pas supprimer
        send_dataObj = form.serializeObject();
        console.log('est tu la fichier????',send_dataObj, send_data);
        continuer = true;


        if (form.validate() && continuer)
        {
            form.parent().parent().blockUI_start();
            Init.importerExcel(type, send_data).then(function(data)
            {
                console.log('retour', data);
                form.parent().parent().blockUI_stop();
                if (data.data!=null && !data.errors)
                {

                    iziToast.success({
                        title: (!send_dataObj.id ? 'AJOUT' : 'MODIFICATION'),
                        message: "succès",
                        position: 'topRight'
                    });
                    $("#modal_addliste" + type).modal('hide');

                    if (type.indexOf("medicament")!==-1){
                        window.location.href = '#!/list-medicament';
                        window.location.reload();
                    }
                }
                else
                {
                    iziToast.error({
                        title: "",
                        message: '<span class="h4">' + data.errors + '</span>',
                        position: 'topRight'
                    });
                }
            }, function (msg)
            {
                form.parent().parent().blockUI_stop();
                iziToast.error({
                    title: (!send_data.id ? 'AJOUT' : 'MODIFICATION'),
                    message: '<span class="h4">Erreur depuis le serveur, veuillez contactez l\'administrateur</span>',
                    position: 'topRight'
                });
                console.log('Erreur serveur ici = ' + msg);
            });

        }
    };

    $scope.fusion = function(e,type,from='modal')
    {
        console.log('arrive ici');
        e.preventDefault();

        var form = $('#form_addfusion' + type);

        var formdata=(window.FormData) ? ( new FormData(form[0])): null;
        var send_data=(formdata!==null) ? formdata : form.serialize();

        // A ne pas supprimer
        send_dataObj = form.serializeObject();
        console.log('est tu la fichier????',send_dataObj, send_data);
        continuer = true;

        if (type.indexOf('medicament')!==-1)
        {
            send_data.append("ligne_medicaments", JSON.stringify($scope.panier));
            if ($scope.panier.length < 2)
            {
                iziToast.error({
                    title: "",
                    message: "Il faut au moins deux medicaments",
                    position: 'topRight'
                });
                continuer = false;
            }
        }

        if (form.validate() && continuer)
        {
            form.parent().parent().blockUI_start();
            Init.fusionner(type, send_data).then(function(data)
            {
                console.log('retour', data);
                form.parent().parent().blockUI_stop();
                if (data.data!=null && !data.errors)
                {

                    iziToast.success({
                        title: (!send_dataObj.id ? 'AJOUT' : 'FUSION'),
                        message: "succès",
                        position: 'topRight'
                    });
                    $("#modal_addfusion" + type).modal('hide');

                    if (type.indexOf("medicament")!==-1){
                        window.location.href = '#!/list-medicament';
                        window.location.reload();
                    }
                }
                else
                {
                    iziToast.error({
                        title: "",
                        message: '<span class="h4">' + data.errors + '</span>',
                        position: 'topRight'
                    });
                }
            }, function (msg)
            {
                form.parent().parent().blockUI_stop();
                iziToast.error({
                    title: (!send_data.id ? 'AJOUT' : 'FUSION'),
                    message: '<span class="h4">Erreur depuis le serveur, veuillez contactez l\'administrateur</span>',
                    position: 'topRight'
                });
                console.log('Erreur serveur ici = ' + msg);
            });

        }
    };

    $scope.detailler = function(e,type,from='modal')
    {
        console.log('arrive ici');
        e.preventDefault();

        var form = $('#form_adddetailler' + type);

        var formdata=(window.FormData) ? ( new FormData(form[0])): null;
        var send_data=(formdata!==null) ? formdata : form.serialize();

        // A ne pas supprimer
        send_dataObj = form.serializeObject();
        console.log('est tu la fichier????',send_dataObj, send_data);
        continuer = true;

        if (form.validate() && continuer)
        {
            form.parent().parent().blockUI_start();
            Init.addDetail(type, send_data).then(function(data)
            {
                console.log('detail', data);
                form.parent().parent().blockUI_stop();
                if (data.data!=null && !data.errors)
                {

                    iziToast.success({
                        title: (!send_dataObj.id ? 'DETAILLER' : 'DETAILLER'),
                        message: "succès",
                        position: 'topRight'
                    });
                    $("#modal_adddetailler" + type).modal('hide');

                    if (type.indexOf("medicament")!==-1){
                        window.location.href = '#!/list-medicament';
                        window.location.reload();
                    }
                }
                else
                {
                    iziToast.error({
                        title: "",
                        message: '<span class="h4">' + data.errors + '</span>',
                        position: 'topRight'
                    });
                }
            }, function (msg)
            {
                form.parent().parent().blockUI_stop();
                iziToast.error({
                    title: (!send_data.id ? 'AJOUT' : 'FUSION'),
                    message: '<span class="h4">Erreur depuis le serveur, veuillez contactez l\'administrateur</span>',
                    position: 'topRight'
                });
                console.log('Erreur serveur ici = ' + msg);
            });

        }
    };

    $scope.redirectToAbonnement=function (){
        window.location.href = '#!/list-abonnement';
        window.location.reload();
    };

    $scope.assistedListe = false;
    $scope.showModalUpdate=function (type,itemId, forceChangeForm=false)
    {
        reqwrite = type + "s" + "(id:"+ itemId + ")";

        Init.getElement(reqwrite, listofrequests_assoc[type + "s"]).then(function(data)
        {
            var item = data[0];
            $scope.itemUpdated = data[0];
            $scope.typeUpdated = type;

            // console.log('item ', type, item);


            $scope.updatetype = type;
            $scope.updateelement = item;


            $scope.showModalAdd(type, true);

            $scope.fromUpdate = true;

            $('#id_' + type).val(item.id);

            if (type.indexOf("typeclient")!==-1)
            {
                $('#nom_' + type).val(item.nom);
            }
            else if (type.indexOf("typemedicament")!==-1)
            {
                $('#nom_' + type).val(item.libelle);
            }
            else if (type.indexOf("typemotif")!==-1)
            {
                $('#designation_' + type).val(item.designation);
            }
            else if (type.indexOf("motif")!==-1)
            {
                $('#designation_' + type).val(item.designation);
                $('#typemotif_' + type).val(item.type_motif_id);
            }
            else if (type.indexOf("famillemedicament")!==-1)
            {
                $('#nom_' + type).val(item.libelle);
            }
            else if (type.indexOf("categorie")!==-1)
            {
                $('#nom_' + type).val(item.nom);
                $('#taux_' + type).val(item.taux);
            }
            else if (type.indexOf("medicament")!==-1)
            {
                $('#designation_' + type).val(item.designation);
                $('#code_' + type).val(item.code);
                $('#cip1_' + type).val(item.cip);
                $('#cip2_' + type).val(item.cip2);
                $('#cip3_' + type).val(item.cip3);
                $('#cip4_' + type).val(item.cip4);
                $('#noart_' + type).val(item.noart);
                $('#type_medicament_' + type).val(item.type_medicament.id);
                $('#famille_medicament_' + type).val(item.famille_medicament_id);
                $('#categorie_' + type).val(item.categorie_id);
                //$('#tva_' + type).val(item.tva);
                $('#with_tva_' + type).prop('checked', item.with_tva);
                $('#prix_cession_' + type).val(item.prix_cession);
                $('#prix_public_' + type).val(item.prix_public);
                $('#qte_rayon_' + type).val(item.qte_rayon);
                $('#qte_reserve_' + type).val(item.qte_reserve);
                $('#qte_seuil_min_' + type).val(item.qte_seuil_min);
                $('#qte_seuil_max_' + type).val(item.qte_seuil_max);
            }
            else if (type.indexOf("stock")!==-1) //Entree de stock et sortie de stock
            {
                console.log('item stock', item);
                //$('#is_buffet_' + type).val('true');
                $('#medicament_' + type).val(item.ligne_livraison.ligne_commande.medicament_id);
                $('#nommedicament_' + type).val(item.ligne_livraison.ligne_commande.medicament.designation);
                $('#motif_' + type).val(item.motif_id);
                $('#quantity_' + type).val(item.quantity);
            }
            else if (type.indexOf("retour")!==-1) //Retour
            {
                $('#date_' + type).val(item.date);
                $('#motif_' + type).val(item.motif_id);
                $('#bon_livraison_' + type).val(item.bon_livraison_id).trigger('change');

                var liste_retours = [];
                $.each(item.ligne_retours, function (keyItem, valueItem) {
                    liste_retours.push({"id":valueItem.medicament_id,"medicament_id":valueItem.medicament_id,"designation":valueItem.medicament.designation, "tva":valueItem.medicament.with_tva, "quantity" : valueItem.quantity, "prix_cession":valueItem.medicament.prix_cession});
                });
                $scope.panier = [];
                $scope.panier = liste_retours;
                $scope.calculateTotal('retour');
            }
            else if (type.indexOf("caisse")!==-1)
            {
                $('#code_' + type).val(item.code_caisse);
                $('#user_ip_' + type).val(item.adresse_mac);
            }
            else if (type.indexOf("cloture") !== -1) {

                $('#somme_init_' + type).val(item.somme_init);
                $('#somme_verse_' + type).val(item.somme_verse);
                $('#date_' + type).val(item.date_cloture);

                var liste_detailclotures = [];
                $.each(item.cloturemonaies, function (keyItem, valueItem) {
                    liste_detailclotures.push({"id":valueItem.monaie_id,"monaie_id":valueItem.monaie_id, "nombre":valueItem.nombre,"valeur":valueItem.monaie.valeur});
                });

                $scope.details_monnaie = liste_detailclotures;

            }
            else if (type.indexOf("versement")!==-1)
            {
                $('#caisse_' + type).val(item.caisse_id);
                $('#montant_verser_' + type).val(item.montant_verser);
                $('#mode_paiement_ ' + type).val(item.mode_paiement);
                $('#commentaire_' + type).val(item.commetaires);
            }
            else if (type.indexOf("depense")!==-1)
            {
                $('#montant_' + type).val(item.montant_decaisse);
                $('#motif_' + type).val(item.motif_decaisse);
            }
            else if (type.indexOf("zonelivraison")!==-1)
            {
                $('#designation_' + type).val(item.designation);
                $('#tarif_' + type).val(item.tarif);
            }
            else if (type.indexOf("boncommande") !== -1)
            {
                $('#fournisseur_' + type).val(item.fournisseur_id);

                var liste_lignecommandes = [];
                $.each(item.ligne_commandes, function (keyItem, valueItem) {
                    liste_lignecommandes.push({"id":valueItem.medicament.id,"medicament_id":valueItem.medicament.id, "designation":valueItem.medicament.designation, "qte_commande" : valueItem.qte_commande, "prix_achat":valueItem.prix_achat});
                });

                $scope.panier = [];
                $scope.panier = liste_lignecommandes;

            }
            else if (type.indexOf("factureproforma") !== -1) {

                $('#fournisseur_' + type).val(item.fournisseur_id);

                var liste_ligneproformas = [];
                $.each(item.ligne_factures, function (keyItem, valueItem) {
                    liste_ligneproformas.push({"id":valueItem.medicament_id,"medicament_id":valueItem.medicament_id, "designation":valueItem.medicament.designation, "qte" : valueItem.qte, "prix_unitaire": valueItem.prix_unitaire });
                });

                $scope.panier = [];
                $scope.panier = liste_ligneproformas;

            }
            else if (type.indexOf("bonlivraison") !== -1) {

                $('#fournisseur_' + type).val(item.bon_commande.fournisseur_id);
                $('#numerofournisseur_' + type).val(item.numero_bl_fournisseur);
                $('#datefournisseur_' + type).val(item.date_bl_fournisseur);

                var liste_lignelivraisons = [];
                $.each(item.lignelivraisons, function (keyItem, valueItem) {
                    liste_lignelivraisons.push({"id":valueItem.ligne_commande.medicament.id,"medicament_id":valueItem.ligne_commande.medicament.id,"code":valueItem.ligne_commande.medicament.code, "designation":valueItem.ligne_commande.medicament.designation,"tva":valueItem.ligne_commande.medicament.with_tva, "qte_livre" : valueItem.qte_livre, "qte_bonus" : valueItem.qte_bonus, "prix_cession":valueItem.prix_cession, "prix_public":valueItem.prix_public});
                });
                $scope.panier = [];
                $scope.panier = liste_lignelivraisons;
                $scope.calculateTotal('bonlivraison');

            }
            else if (type.indexOf("vente") !== -1) {
                $scope.getelements('affiles');
                $dd = $scope.formatDate(item.created_at);
                $('#client_' + type).val(item.client_id);
                $('#datevente_' + type).val(item.created_at);
                $('#assurance_' + type).val(item.assurance_id);
                $('#tauxpriseencharge_' + type).val(item.pourcentage_payeur);
                $('#matriculepatient_' + type).val(item.matricule_patient);
                $('#mode_paiement_' + type).val(item.mode_paiement_id);
                $('#remise_' + type).val(item.pourcentage_remise);
                $('#remisevaleur_' + type).val(item.remise_valeur);
                $('#encaisse_' + type).val(item.somme_encaisse);
                $('#caisse_' + type).val(item.caisse_id);
               if (item.client_id != null)
               {
                   $('#souscripteur_' + type).val(item.client.souscripteur);
               }
                $scope.affiles = item.affile;
                if (item.affile_id != null)
                {
                    $('#affile_' + type).val(item.affile_id);
                }
                console.log($scope.affiles, item.affile_id, $("#affile_vente"));

                $scope.client_lambda_vente = '';

                if (item.client_id==null)
                {
                    $scope.client_lambda_vente = 'on';
                    $("#client_lambda_vente").prop('checked', true);
                }

                var liste_ligneventes = [];
                $.each(item.details_ventes, function (keyItem, valueItem) {
                    liste_ligneventes.push({"id":valueItem.ligne_livraison.ligne_commande.medicament.id,"medicament_id":valueItem.ligne_livraison.ligne_commande.medicament.id,"code":valueItem.ligne_livraison.ligne_commande.medicament.code, "designation":valueItem.ligne_livraison.ligne_commande.medicament.designation,"tva":valueItem.ligne_livraison.ligne_commande.medicament.tva, "qte_vendue" : valueItem.qte_vendu, "prix_unitaire":valueItem.prix_unitaire});
                });

                $scope.panier = [];
                $scope.panier = liste_ligneventes;
                $scope.calculateTotal('vente');
            }
            else if (type.indexOf("client")!==-1)
            {
                $('#nomcomplet_' + type).val(item.nomcomplet);
                $('#matricule_' + type).val(item.matricule);
                $('#telephone_' + type).val(item.telephone);
                $('#type_client_' + type).val(item.type_client.id);
                $('#zone_livraison_' + type).val(item.zone_livraison_id);
                $('#email_' + type).val(item.email);
                $('#adresse_' + type).val(item.adresse);
                $('#pourcentage_' + type).val(item.pourcentage);
                $('#assurance_' + type).val(item.assurance_id);
                $('#souscripteur_' + type).val(item.souscripteur);

                var liste_affile = [];
                $.each(item.affiles, function (keyItem, valueItem) {
                    liste_affile.push({"id":valueItem.id,"nomcomplet":valueItem.nomcomplet});
                });
                console.log(liste_affile)
                $scope.panierAffile = [];
                $scope.panierAffile = liste_affile;
            }
            else if (type.indexOf("assurance")!==-1)
            {
                //$('#matricule_' + type).val(item.matricule);
                $('#nomcomplet_' + type).val(item.nomcomplet);
                $('#telephone_' + type).val(item.telephone);
                $('#email_' + type).val(item.email);
            }
            else if (type.indexOf("fournisseur")!==-1)
            {
                $('#nom_' + type).val(item.nom);
                $('#adresse_' + type).val(item.adresse);
                $('#telephone_' + type).val(item.telephone);
                $('#email_' + type).val(item.email);
            }
            else if (type.indexOf("paiement")!==-1)
            {
                $('#commentaire_' + type).val(item.commentaire);
                $('#remise_' + type).val(item.remise);
                $('#montant_' + type).val(item.montant);
                $('#mode_paiement_' + type).val(item.mode_paiement);
            }
            else if (type.indexOf("typeproduit")!==-1)
            {
                $('#designation_' + type).val(item.designation);
            }
            else if (type.indexOf("inventaire")!==-1)
            {
                $('#code_' + type).val(item.code_inventaire);

                var liste_ligneinventaires = [];
                $.each(item.details_inventaires, function (keyItem, valueItem) {
                    liste_ligneinventaires.push({"id":valueItem.medicament_id,"medicament_id":valueItem.medicament_id, "designation":valueItem.medicament.designation, "current_quantity" : valueItem.qte_app, "qté_inventaire":valueItem.qté_inventorie});
                });

                $scope.panier = [];
                $scope.panier = liste_ligneinventaires;

            }
            else if (type.indexOf("commande")!==-1)
            {
                $scope.client_lambda_commande = '';
                $scope.commandeview = item;

                $scope.voir = [
                    {ingredient_designation:"viande",quantite:2,prix:3500},
                    {ingredient_designation:"poisson",quantite:1,prix:2500}
                ];

                //console.log('voir commande', JSON.parse('[{\"ingredient_designation\":\"viande\",\"quantite\":2,\"prix\":3500},{\"ingredient_designation\":\"poisson\",\"quantite\":1,\"prix\":2500}]'));




                $.each($scope.commandeview.commande_produits, function (key, value)
                {
                    $scope.commandeview.commande_produits[key].liste_ingredient = JSON.parse(value.liste_ingredient);

                });
                console.log('commandeview', $scope.commandeview);


                //$scope.$apply();
            }
            else if (type.indexOf("recouvrement")!==-1)
            {
                $('#client_' + type).val(item.client_id);
                $('#remise_' + type).val(item.remise);
                $('#caisse_' + type).val(item.caisse.id);
                $('#assurance_' + type).val(item.assurance_id);
                $('#modepaiement_' + type).val(item.mode_paiement_id);
                $('#montant_' + type).val(item.montant_verse);

                var liste_lignerecouvrements = [];
                $.each(item.ventes_recouvre, function (keyItem, valueItem) {
                    liste_lignerecouvrements.push({"id":valueItem.vente_id, "vente_id":valueItem.vente_id, "numero_ticket":valueItem.vente.numero_ticket, "total_ttc":valueItem.vente.total_ttc, "nb_click" : 1, "somme":valueItem.somme_recouvre});
                });

                $scope.selectionVente = [];
                $scope.selectionVente = liste_lignerecouvrements;
                $scope.calculateTotal('recouvrement');

/*
                $.each($scope.clients, function (key, value) {
                    if (value.id === item.client_id)
                    {
                        $scope.clientSelected=value;
                        console.log('clientSelected', $scope.clientSelected);
                        return false;
                    }
                });
                $.each($scope.assurances, function (key, value) {
                    if (value.id === item.assurance_id)
                    {
                        $scope.assuranceSelected=value;
                        console.log('assuranceSelected', $scope.assuranceSelected);
                        return false;
                    }
                });

                $scope.recouvrementview = item;

                $scope.recouvrement_ventes = [];
                $.each($scope.recouvrementview.ventes, function (key, value) {
                    $scope.recouvrement_ventes.push(value.id);
                });
                console.log('lancer', $scope.recouvrement_ventes);
*/
            }
            else if (type.indexOf("role")!==-1)
            {
                $('#name_' + type).val(item.name);
                $scope.roleview = item;

                $scope.role_permissions = [];
                $.each($scope.roleview.permissions, function (key, value) {
                    $scope.role_permissions.push(value.id);
                });
                console.log('lancer', $scope.role_permissions);
            }
            else if (type.indexOf("user")!==-1)
            {
                $('#name_' + type).val(item.name);
                $('#role_' + type).val(item.roles[0].id).attr('disabled', forceChangeForm);
                $('#email_' + type).val(item.email).attr('readonly', forceChangeForm);
                $('#password_' + type).val("");
                $('#confirmpassword_' + type).val("");
                $('#img' + type)
                    .val("")
                    .attr('required',false).removeClass('required');
                $('#affimg' + type).attr('src',(item.image ? item.image : imgupload));
                $scope.userview = item;
            }

        }, function (msg) {
            iziToast.error({
                message: "Erreur depuis le serveur, veuillez contactez l'administrateur",
                position: 'topRight'
            });
            console.log('Erreur serveur ici = ' + msg);
        });
    };


    $scope.showModalClonage=function (type,itemId)
    {
        reqwrite = type + "s" + "(id:"+ itemId + ")";

        Init.getElement(reqwrite, listofrequests_assoc[type + "s"]).then(function(data)
        {
            var item = data[0];

            console.log('item ', type, item);

            $scope.updatetype = type;
            $scope.updateelement = item;

            $scope.showModalAdd(type);

            // Pour le clonage, on vide l'id pour permettre l'insertion
            //$('#id_' + type).val(item.id);
            if (type.indexOf("menu")!==-1)
            {
                $('#libelle_' + type).val(item.libelle);
                $('#dateprevue_' + type).val(item.date_prevue);
                $('#tempsjournee_' + type).val(item.temps_journee.id);
                $scope.menuview = item;

                $scope.menu_consommations = [];
                $.each($scope.menuview.menu_consommations, function (key, value) {
                    $scope.menu_consommations.push(value.consommation_id);
                });
                console.log('lancer', $scope.menu_consommations);
            }

        }, function (msg) {
            iziToast.error({
                message: "Erreur depuis le serveur, veuillez contactez l'administrateur",
                position: 'topRight'
            });
            console.log('Erreur serveur ici = ' + msg);
        });
    };


    // Permet de vérifier si un id est dans un tableau
    $scope.isInArrayData = function(e,idItem,data, typeItem="menu") {
        response = false;
        $.each(data, function (key, value) {
            if (typeItem.indexOf('menu')!==-1)
            {
                if (value.consommation_id == idItem)
                {
                    response = true;
                }
            }
            else if (typeItem.indexOf('role')!==-1)
            {
                if (value.id == idItem)
                {
                    response = true ;
                }
            }
            //return response;
        });
        //console.log('ici', response);

        return response;
    };
    $scope.getEtatStock = function()
    {

       var form = $("#formulaire");
       var formdata=(window.FormData) ? ( new FormData(form[0])): null;
       var send_data=(formdata!==null) ? formdata : form.serialize();
       send_dataObj = form.serializeObject();
       var deferred=$q.defer();
       $.ajax
       (
           {
               url: BASE_URL + 'medoc/test/',
               type:'POST',
               contentType:false,
               processData:false,
               DataType:'text',
               data:send_dataObj,
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
               },
               beforeSend: function()
               {
                   $('#modal_etatstock').blockUI_start();
               },success:function(response)
               {
                   $('#modal_etatstock').blockUI_stop();
                   factory.data=response;
                   deferred.resolve(factory.data);
               },
               error:function (error)
               {
                   $('#modal_etatstock').blockUI_stop();
                   console.log('erreur serveur', error);
                   deferred.reject(msg_erreur);

               }
           }
       );
       return deferred.promise;
    };


    // Permet soit d'ajouter ou de supprimer une ligne au niveau de la reservation
    $scope.forligne = function(e,type,action,idItem=0,parent=0)
    {
        e.preventDefault();

        if (type.indexOf("ligne_inventaire")!==-1)
        {
            if (angular.isNumber(action) && action > 0)
            {
                $scope.ligne_inventaires.push({'medicament_id':0, 'qte_app':0, 'qte_inventorie':0, 'ligne_regularisation':null});
                console.log('voir = ', $scope.ligne_inventaires);
                $scope.reInitAtForLigne('inventaire');
            }
            else
            {
                console.log('action', action, 'idItem', idItem, "parent", parent);

                $scope.ligne_inventaires.splice(idItem,1);

                $timeout(function(){
                    console.log('attend---------------');

                    $.each($scope.ligne_inventaires, function (keyItem, oneItem) {
                        var interval_refresh_ligneinv = setInterval(function ()
                        {
                            console.log('intervall inv', oneItem);
                            if ($('.ligne_inventaire[data-ligne='+(keyItem)+']').length)
                            {
                                $scope.actualquantity_ligneinventaire[keyItem] = oneItem.qte_inventorie;
                                $('.ligne_inventaire[data-ligne='+(keyItem)+']')
                                    .find('[name^="quantity"]').val(oneItem.qte_inventorie).trigger('change');

                                $scope.produit_ligneinventaire[keyItem] = oneItem.medicament_id;
                                $('.ligne_inventaire[data-ligne='+(keyItem)+']')
                                    .find('[name^="produit"]').val(oneItem.medicament_id).trigger('change');

                                $scope.regularisation_ligneinventaire[keyItem] = oneItem.ligne_regularisation_id;
                                $('.ligne_inventaire[data-ligne='+(keyItem)+']')
                                    .find('[name^="regularisation"]').val(oneItem.ligne_regularisation_id).trigger('change');


                                if (!oneItem.can_updated)
                                {
                                    $('.ligne_inventaire[data-ligne='+(keyItem)+']')
                                        .find('[id^="remove"]').addClass('d-none');
                                }
                                else
                                {
                                    $('.ligne_inventaire[data-ligne='+(keyItem)+']')
                                        .find('[id^="remove"]').removeClass('d-none');
                                }

                                /*
                                                                    $('.ligne_inventaire[data-ligne='+(keyItem)+']')
                                                                        .find('[name^="regularisation"]').attr('readonly', !oneItem.can_updated);
                                                                    $('.ligne_inventaire[data-ligne='+(keyItem)+']')
                                                                        .find('[name^="quantity"]').attr('readonly', !oneItem.can_updated);
                                                                    $('.ligne_inventaire[data-ligne='+(keyItem)+']')
                                                                        .find('[name^="produit"]').attr('disabled', !oneItem.can_updated);

                                */
                                setTimeout(function ()
                                {
                                    clearInterval(interval_refresh_ligneinv);
                                },500);
                            }
                        },500);
                    });

                });
            }
            $scope.reInit();
        }

    };

    $scope.itemChange_detailingredient = function(parent,forItem, child=0)
    {
        if (forItem.indexOf('typeingredient')!==-1)
        {
            $('[name^="typeingredient_detail"]').each(function (keyNum, valueNum) {
                var verif_occurence = 0;
                that = $(this);
                $('[name^="typeingredient_detail"]').each(function (keyNumOc, valueNumOc) {
                    if (Number($(this).val())==Number(that.val()))
                    {
                        verif_occurence++;
                    }
                    return !(verif_occurence>1);
                });
                if (verif_occurence>1)
                {
                    iziToast.error({
                        title: "",
                        message: "Vous ne pouvez pas selectionner le même type d'ingredients deux fois<br><br>",
                        position: 'topRight'
                    });
                    setTimeout(function () {
                        that.val('');
                    },500);
                }
                return !(verif_occurence>1);
            });
        }
    };

    $scope.calculateTotal = function(type)
    {
        if (type.indexOf('bonlivraison')!==-1)
        {
            $scope.total_ttc_livraison = 0;
            $scope.tvaBL = 0;
            $scope.total_ht_livraison = 0;

            if ($scope.panier.length > 0)
            {
                $.each($scope.panier, function (key, value)
                {
                    $scope.total_ht_livraison = $scope.total_ht_livraison + (value.prix_cession * value.qte_livre);

                    if ( value.tva == 1 )
                    {
                        $scope.tvaBL = $scope.tvaBL + (value.prix_cession * value.qte_livre * 0.18);
                    }

                });
                $scope.total_ttc_livraison = ($scope.total_ht_livraison + $scope.tvaBL) ;
                console.log('totals_livraison',$scope.total_ht_livraison, $scope.total_ttc_livraison, $scope.tvaBL);
            }
        }
        else if (type.indexOf('retour')!==-1)
        {
            $scope.total_remboursement = 0;

            if ($scope.panier.length > 0)
            {
                $.each($scope.panier, function (key, value)
                {
                    $scope.total_remboursement = $scope.total_remboursement + (value.prix_cession * value.quantity);

                });
                console.log('totals_retour',$scope.total_remboursement);
            }
        }
        else if (type.indexOf('recouvrement')!==-1)
        {
            $scope.total_recouvre = 0;

            if ($scope.selectionVente.length > 0)
            {
                $.each($scope.selectionVente, function (key, value)
                {
                    $scope.total_recouvre = $scope.total_recouvre + value.somme;

                });
                $scope.total_recouvre = ($scope.total_recouvre - Number($('#remise_recouvrement').val()) );
                console.log('total_recouvre',$scope.total_recouvre);
            }
        }
        else if (type.indexOf('vente')!==-1)
        {
            $scope.total_ttc_vente = 0;
            $scope.tvaVt = 0;
            $scope.remiseVt = 0 ;
            $scope.partPayeur = 0 ;
            $scope.total_ht_vente = 0;
            $scope.total_verse = 0;
            $scope.net_Apaye = 0;
            $scope.monnaie = 0;

            if ($scope.panier.length > 0)
            {
                $.each($scope.panier, function (key, value)
                {
                    $scope.total_ttc_vente = $scope.total_ttc_vente + (value.prix_unitaire * value.qte_vendue);

                    if ( value.tva == 1 )
                    {
                        $scope.tvaVt = $scope.tvaVt + (value.prix_unitaire * value.qte_vendue * 0.18);
                    }

                });
                $scope.total_ht_vente = ($scope.total_ttc_vente - $scope.tvaVt);
                $scope.remiseVt = ((Number($('#remise_vente').val()) * $scope.total_ttc_vente)/100) + Number($('#remisevaleur_vente').val());
                $scope.net_Apaye = ($scope.total_ttc_vente - $scope.remiseVt);
                $scope.partPayeur = (Number($('#tauxpriseencharge_vente').val()) * $scope.net_Apaye)/100;
                $scope.total_verse = ($scope.net_Apaye - $scope.partPayeur);
                $scope.monnaie = ( Number($('#encaisse_vente').val()) - $scope.total_verse);
                console.log('totals_vente',$scope.total_ht_vente, $scope.total_ttc_vente, $scope.tvaVt, $scope.net_Apaye, $scope.partPayeur,$scope.total_verse  );
            }
        }

    };


    $scope.searchsurfacecategorie="";
    $scope.trierElement=function (type,element,propriete="")
    {
        console.log('trierElement');

        if (type.indexOf('client')!==-1)
        {
            if (propriete.match('recouvrement'))
            {
                $.each($scope.clients, function (key, value) {
                    if (value.id == element)
                    {
                        console.log('trierElement');
                        $scope.clientSelected=element;
                        console.log('clientSelected', $scope.clientSelected);
                        return false;
                    }
                });
            }
        }
        else if (type.indexOf('assurance')!==-1)
        {
            if (propriete.match('recouvrement'))
            {
                $.each($scope.assurances, function (key, value) {
                    if (value.id == element)
                    {
                        $scope.assuranceSelected=element;
                        console.log('assuranceSelected', $scope.assuranceSelected);
                        return false;
                    }
                });
            }
        }
    };


    $scope.deleteElement=function (type,itemId)
    {
        var msg = 'Voulez-vous vraiment effectué cette suppression ?';
        var title = 'SUPPRESSION';
        iziToast.question({
            timeout: 0,
            close: false,
            overlay: true,
            displayMode: 'once',
            id: 'question',
            zindex: 999,
            title: title,
            message: msg,
            position: 'center',
            buttons: [
                ['<button class="font-bold">OUI</button>', function (instance, toast) {

                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    Init.removeElement(type, itemId).then(function (data) {

                        console.log('deleted', data);
                        if (data.data && !data.errors)
                        {

                            if (type.indexOf('caisse')!==-1)
                            {
                                $.each($scope.caisses, function (keyItem, oneItem)
                                {
                                    if (oneItem.id===itemId)
                                    {
                                        $scope.caisses.splice(keyItem, 1);
                                        return false;
                                    }
                                });
                            }
                            else if (type.indexOf('typeclient')!==-1)
                            {
                                $.each($scope.typeclients, function (keyItem, oneItem)
                                {
                                    if (oneItem.id===itemId)
                                    {
                                        $scope.typeclients.splice(keyItem, 1);
                                        return false;
                                    }
                                });
                            }
                            else if (type.indexOf('client')!==-1)
                            {
                                if ($scope.clientview && $scope.clientview.id)
                                {
                                    $location.path('list-client');
                                }

                                $.each($scope.clients, function (keyItem, oneItem)
                                {
                                    if (oneItem.id===itemId)
                                    {
                                        $scope.clients.splice(keyItem, 1);
                                        return false;
                                    }
                                });

                                $scope.paginationcli.totalItems--;
                                if($scope.clients.length < $scope.paginationcli.entryLimit)
                                {
                                    $scope.pageChanged('client');
                                }
                            }
                            else if (type.indexOf('typemedicament')!==-1)
                            {
                                $.each($scope.typemedicaments, function (keyItem, oneItem)
                                {
                                    if (oneItem.id===itemId)
                                    {
                                        $scope.typemedicaments.splice(keyItem, 1);
                                        return false;
                                    }
                                });
                            }
                            else if (type.indexOf('typemotif')!==-1)
                            {
                                $.each($scope.typemotifs, function (keyItem, oneItem)
                                {
                                    if (oneItem.id===itemId)
                                    {
                                        $scope.typemotifs.splice(keyItem, 1);
                                        return false;
                                    }
                                });
                            }
                            else if (type.indexOf('motif')!==-1)
                            {
                                $.each($scope.motifs, function (keyItem, oneItem)
                                {
                                    if (oneItem.id===itemId)
                                    {
                                        $scope.motifs.splice(keyItem, 1);
                                        return false;
                                    }
                                });
                            }
                            else if (type.indexOf('famillemedicament')!==-1)
                            {
                                $.each($scope.famillemedicaments, function (keyItem, oneItem)
                                {
                                    if (oneItem.id===itemId)
                                    {
                                        $scope.famillemedicaments.splice(keyItem, 1);
                                        return false;
                                    }
                                });
                            }
                            else if (type.indexOf('categorie')!==-1)
                            {
                                $.each($scope.categories, function (keyItem, oneItem)
                                {
                                    if (oneItem.id===itemId)
                                    {
                                        $scope.categories.splice(keyItem, 1);
                                        return false;
                                    }
                                });
                            }
                            else if (type.indexOf('medicament')!==-1)
                            {
                                if ($scope.medicamentview && $scope.medicamentview.id)
                                {
                                    $location.path('list-medicament');
                                }

                                $.each($scope.medicaments, function (keyItem, oneItem)
                                {
                                    if (oneItem.id===itemId)
                                    {
                                        $scope.medicaments.splice(keyItem, 1);
                                        return false;
                                    }
                                });

                                $scope.paginationmedicament.totalItems--;
                                if($scope.medicaments.length < $scope.paginationmedicament.entryLimit)
                                {
                                    $scope.pageChanged('medicament');
                                }
                            }
                            else if (type.indexOf('entreestock')!==-1)
                            {
                                $.each($scope.entreestocks, function (keyItem, oneItem)
                                {
                                    if (oneItem.id===itemId)
                                    {
                                        $scope.entreestocks.splice(keyItem, 1);
                                        return false;
                                    }
                                });

                                $scope.paginationentreestock.totalItems--;
                                if($scope.entreestocks.length < $scope.paginationentreestock.entryLimit)
                                {
                                    $scope.pageChanged('entreestock');
                                }
                            }
                            else if (type.indexOf('sortiestock')!==-1)
                            {
                                $.each($scope.sortiestocks, function (keyItem, oneItem)
                                {
                                    if (oneItem.id===itemId)
                                    {
                                        $scope.sortiestocks.splice(keyItem, 1);
                                        return false;
                                    }
                                });

                                $scope.paginationsortiestock.totalItems--;
                                if($scope.sortiestocks.length < $scope.paginationsortiestock.entryLimit)
                                {
                                    $scope.pageChanged('sortiestock');
                                }
                            }
                            else if (type.indexOf('retour')!==-1)
                            {
                                $.each($scope.retours, function (keyItem, oneItem)
                                {
                                    if (oneItem.id===itemId)
                                    {
                                        $scope.retours.splice(keyItem, 1);
                                        return false;
                                    }
                                });

                                $scope.paginationretour.totalItems--;
                                if($scope.retours.length < $scope.paginationretour.entryLimit)
                                {
                                    $scope.pageChanged('retour');
                                }
                            }
                            else if (type.indexOf('vente')!==-1)
                            {
                                $.each($scope.ventes, function (keyItem, oneItem)
                                {
                                    if (oneItem.id===itemId)
                                    {
                                        $scope.ventes.splice(keyItem, 1);
                                        return false;
                                    }
                                });

                                $scope.paginationvente.totalItems--;
                                if($scope.ventes.length < $scope.paginationvente.entryLimit)
                                {
                                    $scope.pageChanged('vente');
                                }
                            }
                            else if (type.indexOf('cloture')!==-1)
                            {

                                $.each($scope.clotures, function (keyItem, oneItem)
                                {
                                    if (oneItem.id===itemId)
                                    {
                                        $scope.clotures.splice(keyItem, 1);
                                        return false;
                                    }
                                });

                                $scope.paginationcloture.totalItems--;
                                if($scope.clotures.length < $scope.paginationcloture.entryLimit)
                                {
                                    $scope.pageChanged('cloture');
                                }
                            }
                            else if (type.indexOf('versement')!==-1)
                            {

                                $.each($scope.versements, function (keyItem, oneItem)
                                {
                                    if (oneItem.id===itemId)
                                    {
                                        $scope.versements.splice(keyItem, 1);
                                        return false;
                                    }
                                });

                                $scope.paginationversement.totalItems--;
                                if($scope.clotures.length < $scope.paginationversement.entryLimit)
                                {
                                    $scope.pageChanged('versement');
                                    $scope.getelements('modepaiements');

                                }
                            }
                            else if (type.indexOf('depense')!==-1)
                            {

                                $.each($scope.depenses, function (keyItem, oneItem)
                                {
                                    if (oneItem.id===itemId)
                                    {
                                        $scope.depenses.splice(keyItem, 1);
                                        return false;
                                    }
                                });

                                $scope.paginationdepense.totalItems--;
                                if($scope.depenses.length < $scope.paginationdepense.entryLimit)
                                {
                                    $scope.pageChanged('depense');
                                    $scope.getelements('modepaiements');

                                }
                            }
                            else if (type.indexOf('zonelivraison')!==-1)
                            {
                                $.each($scope.zonelivraisons, function (keyItem, oneItem)
                                {
                                    if (oneItem.id===itemId)
                                    {
                                        $scope.zonelivraisons.splice(keyItem, 1);
                                        return false;
                                    }
                                });
                            }
                            else if (type.indexOf('inventaire')!==-1)
                            {
                                $.each($scope.inventaires, function (keyItem, oneItem)
                                {
                                    if (oneItem.id===itemId)
                                    {
                                        $scope.inventaires.splice(keyItem, 1);
                                        return false;
                                    }
                                });

                                $scope.paginationinventaire.totalItems--;
                                if($scope.inventaires.length < $scope.paginationinventaire.entryLimit)
                                {
                                    $scope.pageChanged('inventaire');
                                }
                            }
                            else if (type.indexOf('assurance')!==-1)
                            {
                                if ($scope.assuranceview && $scope.assuranceview.id)
                                {
                                    $location.path('list-assurance');
                                }

                                $.each($scope.assurances, function (keyItem, oneItem)
                                {
                                    if (oneItem.id===itemId)
                                    {
                                        $scope.assurances.splice(keyItem, 1);
                                        return false;
                                    }
                                });

                                $scope.paginationassurance.totalItems--;
                                if($scope.assurances.length < $scope.paginationassurance.entryLimit)
                                {
                                    $scope.pageChanged('assurance');
                                }
                            }
                            else if (type.indexOf('recouvrement')!==-1)
                            {
                                if ($scope.recouvrementview && $scope.recouvrementview.id)
                                {
                                    $location.path('list-recouvrement');
                                }

                                $.each($scope.recouvrements, function (keyItem, oneItem)
                                {
                                    if (oneItem.id===itemId)
                                    {
                                        $scope.recouvrements.splice(keyItem, 1);
                                        return false;
                                    }
                                });

                                $scope.paginationrecouvrement.totalItems--;
                                if($scope.recouvrements.length < $scope.paginationrecouvrement.entryLimit)
                                {
                                    $scope.pageChanged('recouvrement');
                                }
                            }
                            else if (type.indexOf('boncommande')!==-1)
                            {
                                if ($scope.boncommandeview && $scope.boncommandeview.id)
                                {
                                    $location.path('list-commande');
                                }

                                $.each($scope.boncommandes, function (keyItem, oneItem)
                                {
                                    if (oneItem.id===itemId)
                                    {
                                        $scope.boncommandes.splice(keyItem, 1);
                                        return false;
                                    }
                                });

                                $scope.paginationboncommande.totalItems--;
                                if($scope.boncommandes.length < $scope.paginationboncommande.entryLimit)
                                {
                                    $scope.pageChanged('boncommande');
                                }
                            }
                            else if (type.indexOf('bonlivraison')!==-1)
                            {
                                if ($scope.boncommandeview)
                                {
                                    location.reload();
                                }

                                $.each($scope.bonlivraisons, function (keyItem, oneItem)
                                {
                                    if (oneItem.id===itemId)
                                    {
                                        $scope.bonlivraisons.splice(keyItem, 1);
                                        return false;
                                    }
                                });

                                $scope.paginationbonlivraison.totalItems--;
                                if($scope.bonlivraisons.length < $scope.paginationbonlivraison.entryLimit)
                                {
                                    $scope.pageChanged('bonlivraison');
                                }
                            }
                            else if (type.indexOf('fournisseur')!==-1)
                            {
                                if ($scope.fournisseurview && $scope.fournisseurview.id)
                                {
                                    $location.path('list-fournisseur');
                                }

                                $.each($scope.fournisseurs, function (keyItem, oneItem)
                                {
                                    if (oneItem.id===itemId)
                                    {
                                        $scope.fournisseurs.splice(keyItem, 1);
                                        return false;
                                    }
                                });

                                $scope.paginationfournisseur.totalItems--;
                                if($scope.fournisseurs.length < $scope.paginationfournisseur.entryLimit)
                                {
                                    $scope.pageChanged('fournisseur');
                                }
                            }
                            else if (type.indexOf('factureproforma')!==-1)
                            {
                                $.each($scope.factureproformas, function (keyItem, oneItem)
                                {
                                    if (oneItem.id===itemId)
                                    {
                                        $scope.factureproformas.splice(keyItem, 1);
                                        return false;
                                    }
                                });

                                $scope.paginationfactureproforma.totalItems--;
                                if($scope.factureproformas.length < $scope.paginationfactureproforma.entryLimit)
                                {
                                    $scope.pageChanged('factureproforma');
                                }
                            }
                            else if (type.indexOf('paiement')!==-1)
                            {
                                $scope.pageChanged('paiement');
                            }
                            else if (type.indexOf('role')!==-1)
                            {
                                $.each($scope.roles, function (keyItem, oneItem)
                                {
                                    if (oneItem.id===itemId)
                                    {
                                        $scope.roles.splice(keyItem, 1);
                                        return false;
                                    }
                                });
                            }
                            else if (type.indexOf('user')!==-1)
                            {
                                $.each($scope.users, function (keyItem, oneItem)
                                {
                                    if (oneItem.id===itemId)
                                    {
                                        $scope.users.splice(keyItem, 1);
                                        return false;
                                    }
                                });

                                $scope.paginationuser.totalItems--;
                                if($scope.users.length < $scope.paginationuser.entryLimit)
                                {
                                    $scope.pageChanged('user');
                                }
                            }

                            iziToast.success({
                                title: title,
                                message: "succès",
                                position: 'topRight'
                            });
                        }
                        else
                        {
                            iziToast.error({
                                title: title,
                                message: data.errors,
                                position: 'topRight'
                            });
                        }

                    }, function (msg) {
                        iziToast.error({
                            title: title,
                            message: "Erreur depuis le serveur, veuillez contactez l'administrateur",
                            position: 'topRight'
                        });
                    });

                }, true],
                ['<button>NON</button>', function (instance, toast) {

                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                }],
            ],
            onClosing: function(instance, toast, closedBy){
                console.log('Closing | closedBy: ' + closedBy);
            },
            onClosed: function(instance, toast, closedBy){
                console.log('Closed | closedBy: ' + closedBy);
            }
        });
    };

});


// Vérification de l'extension des elements uploadés
function isValide(fichier)
{
    var Allowedextensionsimg=new Array("jpg","JPG","jpeg","JPEG","gif","GIF","png","PNG");
    var Allowedextensionsvideo=new Array("mp4");
    for (var i = 0; i < Allowedextensionsimg.length; i++)
        if( ( fichier.lastIndexOf(Allowedextensionsimg[i]) ) != -1)
        {
            return 1;
        }
    for (var j = 0; j < Allowedextensionsvideo.length; j++)
        if( ( fichier.lastIndexOf(Allowedextensionsvideo[j]) ) != -1)
        {
            return 2;
        }
    return 0;
}

// FileReader pour la photo
function Chargerphoto(idform)
{
    var fichier = document.getElementById("img"+idform);
    (isValide(fichier.value)!=0) ?
        (
            fileReader=new FileReader(),
                (isValide(fichier.value)==1) ?
                    (
                        fileReader.onload = function (event) { $("#affimg"+idform).attr("src",event.target.result);},
                            fileReader.readAsDataURL(fichier.files[0]),
                            (idform=='produit') ? $("#imgproduit_recup").val("") : ""
                    ):null
        ):(
            alert("L'extension du fichier choisi ne correspond pas aux règles sur les fichiers pouvant être uploader"),
                $('#img'+idform).val(""),
                $('#affimg'+idform).attr("src",""),
                $('.input-modal').val("")
        );
}

function reCompile(element)
{
    var el = angular.element(element);
    $scope = el.scope();
    $injector = el.injector();
    $injector.invoke(function($compile)
    {
        $compile(el)($scope)
    });
    console.log('arrive dans la liaison');
}




//Echec en cas d'enregistrement
function echecEnregistrer(id, nom, sigle) {
    var warning = true;
    var idNomSigle = id+'_'+nom+'_'+sigle+'_'+warning;
    $('#trBailleur_'+id).html('<form method="post" class="fom-inline" >' +
        '<td><input class="form-control" type="text" name="'+id+'" id="nomInput_'+id+'" value="'+nom+'"></td>' +
        '<td><input class="form-control" type="text" name="'+id+'" id="sigleInput_'+id+'" value="'+sigle+'"></td>' +
        '<td>' +
        '<span id="loading_'+id+'">' +
        '<button class="btn btn-success" onclick="enregistrer(\''+id+'\')" style="margin-right: 5px;">Valider <i class="fa fa-save"></i></button>' +
        '<button class="btn btn-danger" onclick="annuler(\''+idNomSigle+'\')">Annuler <i class="fa fa-close"></i></button>' +
        '</span>' +
        '<span class="label label-warning pull-right" id="warning_'+id+'" ><i class="fa fa-warning"></i> modifications<br> non enregistrées</span> ' +
        '</td> ' +
        '</form>');
}

//Champ de text initial
function champInputInitial(id, nomSigle) {
    var nom = $('#nom_'+id).html();
    var sigle = $('#sigle_'+id).html();
    nomSigle = nomSigle.split('_');

    console.log("input");
    if (!nom && !sigle){
        console.log("if");
        nom = nomSigle[0];
        sigle = nomSigle[1];
    }

    var idNomSigle = id+'_'+nom+'_'+sigle;

    $('#trBailleur_'+id).html('<form method="post" class="fom-inline" >' +
        '<td><input class="form-control" type="text" name="'+id+'" id="nomInput_'+id+'" value="'+nom+'"></td>' +
        '<td><input class="form-control" type="text" name="'+id+'" id="sigleInput_'+id+'" value="'+sigle+'"></td>' +
        '<td>' +
        '<span id="loading_'+id+'">' +
        '<button class="btn btn-success" onclick="enregistrer(\''+id+'\')" style="margin-right: 5px;">Valider <i class="fa fa-save"></i></button>' +
        '<button class="btn btn-danger" onclick="annuler(\''+idNomSigle+'\')">Annuler <i class="fa fa-close"></i></button>' +
        '</span>' +
        '</td> ' +
        '</form>');


}

//Champ <td> initial
function champInitial(id,nom,sigle) {
    var verifWarning = sigle.split('_');

    var routeDetatil = "{{ path('bailleur_show', { 'id': 'bailleur.id' }) }}";
    var routeEditer = "{{ path('bailleur_edit', { 'id': 'bailleur.id' }) }}";

    routeDetatil = routeDetatil.replace("bailleur.id",id);
    routeEditer = routeEditer.replace("bailleur.id",id);

    if (verifWarning[1] == "warning"){
        sigle = verifWarning[0];
        $('#trBailleur_'+id).html('' +
            '<td id="nom_'+id+'">'+nom+'</td>' +
            '<td id="sigle_'+id+'">'+sigle+'</td>' +
            '<td>' +
            '<button class="btn btn-info" style="margin-right: 5px;"><a href="'+routeDetatil+'">Voir détail</a></button>' +
            '<button class="btn btn-danger"><a href="'+routeEditer+'">Editer</a></button>' +
            '<span class="label label-warning pull-right" id="warning_'+id+'" ><i class="fa fa-warning"></i> modifications<br> non enregistrées</span> ' +
            '</td>');
    }else {
        $('#trBailleur_'+id).html('' +
            '<td id="nom_'+id+'">'+nom+'</td>' +
            '<td id="sigle_'+id+'">'+sigle+'</td>' +
            '<td>' +
            '<button class="btn btn-info" style="margin-right: 5px;"><a href="'+routeDetatil+'">Voir détail</a></button>' +
            '<button class="btn btn-danger"><a href="'+routeEditer+'">Editer</a></button>' +
            '</td>');
    }


}

//Verifier si le champ est vide ou uniquement constituer d'espace
function estVide(text) {
    return (/\S/.test(text));
}

//Fonction annuler editer
function annuler(bailleur) {
    console.log("annuler");
    console.log(bailleur);
    var bailleur_split = bailleur.split('_');
    var id = bailleur_split[0];
    var nom = bailleur_split[1];
    var sigle = bailleur_split[2];
    if (bailleur_split[3]){
        sigle = sigle+'_warning';
    }
    champInitial(id,nom,sigle);
}

//Fonction editer
function edit(bailleur) {
    console.log(bailleur);
    var bailleur_split = bailleur.split('_');
    var id = bailleur_split[0];
    console.log("id:"+id);
    var nom = bailleur_split[1];
    console.log("nom:"+nom);
    var sigle = bailleur_split[2];
    console.log("sigle:"+sigle);
    var nomSigle = nom+'_'+sigle;


    //champ input initial
    champInputInitial(id, nomSigle);

}

//Fonction enregistrer au niveau de la base de donnees
function enregistrer(id) {
    console.log('enregistrer');
    var nom = $('#nomInput_'+id).val();
    var sigle = $('#sigleInput_'+id).val();
    console.log('nom:'+nom);
    console.log('sigle:'+sigle);
    var bailleur_tmp = {'id':id, 'nom': nom, 'sigle':sigle};
    var videNom = estVide(nom);
    console.log("vide:"+videNom);

    if (videNom){
        var bailleur = (bailleur_tmp);
        console.log("non null");
        $.ajax({
            url:'{{ path("bailleur_new_ajax") }}',
            type: "POST",
            dataType: "json",
            data: {
                "bailleur": bailleur
            },
            async: true,
            timeout: 10000,
            beforeSend: function(){
                $('#loading_'+id+'').html('<div class="progress m-t-10"><div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div></div>');
                $('.progress-bar').animate({width: "30%"}, 100);
            }
        }).
        done(function(data) {
            if(data == 'Unauthorized.'){
                location.href = 'logout';
            }else{
                $('.progress-bar').animate({width: "100%"}, 100);
                setTimeout(function(){
                    $('.progress-bar').css({width: "100%"});
                    setTimeout(function(){
                        $('.my-box').html(data);
                    }, 100);
                    // $('#'+id+'').fadeOut(1000);
                    $('#loading_'+id+'').html('');
                    champInitial(id, nom, sigle);
                }, 500);
            }
            console.log("cool");
            //document.getElementById(''+id+'').innerHTML = '';
            $.toast({
                heading: 'Opération réussie',
                text: '<h2>Enregistrer </h2>',
                position: 'bottom-right',
                loaderBg:'#ff6849',
                icon: 'success',
                hideAfter: 3000,
                stack: 6
            });
        }).
        error(function() {
            console.log("error");
            $.toast({
                heading: 'Opération échouée',
                text: '<h2>Non enregistrer</h2>',
                position: 'bottom-right',
                loaderBg:'#ff6849',
                icon: 'error',
                hideAfter: 3000,
                stack: 6
            });
            echecEnregistrer(id, nom, sigle);
        });
    }
}
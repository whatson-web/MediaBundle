# Installation : 

## Parametrer les infos serveur dans le fichier index : 

    var CONF = {
    url: '',
    endPointMedia: '',
    assetUrl: ''
    }; 

**url** : url du serveur (pour les requêtes : http://monserveur:8888) 

**endPointMedia** : en point du service media (/api/medias)

**assetUrl** : endPoint des fichiers : (http://monserveurmedia:8888)

## Appel de la popup : 

    const url = `/wh-finder/index.html?access_token=[access_token]#/?id=[id]&type=[type]`; 
    
    window.open(url,"wh media center","location=no, menubar=no, status=no, scrollbars=no, menubar=no, width=800, height=600");

**access_token** : selon autorisation nécessaire sur le serveur

**id** : id du champ à renseigner

**type** : 
- `api` : pour une url d'api
- `url` : pour l'url du media
- `id` : pour l'id du media

## Paramètre serveur : 

- ApiPlateform pour les geters
- `/upload` pour l'upload de media
- `/delete/{id}` pour supprimer un media
- `/upload/{id}` pour la mise à jour d'un media
- champ `urlLast` pour une url avec timestamp pour eviter le cache des images
- champ `alt` 
- champ `description` 

# Todo 

Fichier de paramètres extérieurs à placer dans .gitignore 

Croping des images en ligne

taille minimum de la fenête d'edition



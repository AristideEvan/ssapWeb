let map;
let points = [];
let markers = L.markerClusterGroup();
let layerControl =L.control.layers();
var donnees={};
let climat_id=null;
let sol_id=null;
let domaine_id=null;
let theme_id=null;
let pays_id=null;
let localite_id=null;



function populateSelect2(datas) {
    const selectPratiques = document.getElementById('select2');
    selectPratiques.innerHTML = ''; // Effacer les options existantes

    // Ajouter une première option par défaut
    const defaultOption = document.createElement('option');
    defaultOption.value = ''; // Pas de valeur
    defaultOption.textContent = 'sélectionner une localite'; // Texte de l'option par défaut
    defaultOption.selected = true; // Sélectionner cette option par défaut
    defaultOption.disabled = true; // Désactiver pour obliger un choix
    selectPratiques.appendChild(defaultOption);

    // Ajouter les options des pratiques
    datas.forEach(pratique => {
        const option = document.createElement('option');
        option.value = pratique.pratique_id; // Utiliser l'identifiant de la pratique
        option.textContent = pratique.pratiqueLibelle; // Utiliser le libellé de la pratique
        selectPratiques.appendChild(option);
    });
}

function populateSelect1(datas) {
    const selectDatas = document.getElementById('select1');
    selectDatas.innerHTML = ''; // Effacer les options existantes

    // Ajouter une première option par défaut
    const defaultOption = document.createElement('option');
    defaultOption.value = ''; // Pas de valeur
    defaultOption.textContent = 'Selectionner un Pays '; // Texte de l'option par défaut
    defaultOption.selected = true; // Sélectionner cette option par défaut
    defaultOption.disabled = true; // Désactiver pour obliger un choix
    selectDatas.appendChild(defaultOption);

    // Ajouter les options pour chaque localité
    Object.keys(datas).forEach(function(id) {
        const option = document.createElement('option');
        option.value = id;  // Utiliser l'ID (p0) comme valeur
        option.textContent = datas[id];  // Utiliser le pays comme texte visible
        selectDatas.appendChild(option);
    });
}

function initmap( datas){
    var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    });

    var osmHOT = L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors, Tiles style by Humanitarian OpenStreetMap Team hosted by OpenStreetMap France'
    });

    var openTopoMap = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: 'Map data: © OpenStreetMap contributors, SRTM | Map style: © OpenTopoMap (CC-BY-SA)'
    });
    if (map) {
        // Si oui, retirer les clusters existants
        map.removeLayer(markers);   
        map.removeControl(layerControl);
    } else {
        // Si non, initialiser la carte avec les couches par défaut
        map = L.map('map', { minZoom: 5 // Définissez le niveau de zoom minimum ici 
        }).setView([16.8851072489, 2.3150724758], 5.48);
        osm.addTo(map); // Ajouter la couche par défaut à la carte // Ajouter la couche des villes par défaut à la carte
    }
    markers = L.markerClusterGroup(
        { 
            maxClusterRadius: function(zoom) { return (zoom < 5.48) ? 50 : 40; // Rayon du cluster plus grand pour les niveaux de zoom inférieurs 
            } 
        });
        datas.forEach(point => {
            const popupContent = `
                <div style="max-height: 400px; overflow-y: auto; text-align: center; padding: 10px; background-color: rgba(255, 255, 255, 0.8); border-radius: 8px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); min-width: 500px; max-width: 100%; width: 600px;">
                    <h3>${point.pratiqueLibelle}</h3>
                    <div style="margin-top: 10px;">
                        <img src="${point.vedette_path || ''}" alt="Image de la pratique" style="max-width: 100%; height: auto; margin-top: 10px;" class="pratique-image" data-id="${point.pratique_id}" data-route="/details-pratiques/${point.pratique_id}">
                    </div>
                    <div style="margin-top: 10px;">
                        <h4 style="color: green;">Objectifs</h4>
                        <p>${point.objectif}</p>
                    </div>
                </div>
            `;
    
            const marker = L.marker([point.latitude, point.longitude])
                .bindPopup(popupContent, { 
                    maxWidth: 700, 
                    minWidth: 500, 
                    maxHeight: 300 
                });
    
            marker.on('mouseover', function (e) { 
                marker.bindTooltip(point.pratiqueLibelle, { 
                    permanent: false, direction: 'top', offset: L.point(0, -20), opacity: 0.8 
                }).openTooltip(); 
            });
    
            marker.on('mouseout', function (e) { marker.closeTooltip(); });
            markers.addLayer(marker);
        });
    
        // Ajouter les clusters à la carte
        map.addLayer(markers);
    
        // Ajouter un gestionnaire d'événements click sur les images
        document.addEventListener('click', function(event) {
            if(event.target.classList.contains('pratique-image')) {
                const route = event.target.getAttribute('data-route');
                window.location.href = route;
            }
        });
    
        // Ajouter des couches supplémentaires au contrôle de couches
        var baseLayers = {
            "OpenStreetMap": osm,
            "OSM Humanitarian": osmHOT,
            "OpenToMap": openTopoMap
        };
    
        layerControl = L.control.layers(baseLayers).addTo(map);
        //L.control.fullscreen().addTo(map);
}

function contours() {
    map = L.map('map', { minZoom: 5 // Définissez le niveau de zoom minimum ici 
    }).setView([16.8851072489, 2.3150724758], 5.48);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        opacity: 1
    }).addTo(map);

    // Charger le fichier JSON contenant les limites des pays
    fetch('/data/json.json')
        .then(response => response.json())
        .then(data => {
            // Ajouter les limites des pays en tant que polygones
            L.geoJSON(data, {
                style: {
                    color: '#196f3d',
                    weight: 4,
                    opacity: 1,
                    fillColor: 'blue',
                    fillOpacity: 0.1
                }
            }).addTo(map);
        })
        .catch(error => console.error('Erreur lors du chargement des limites des pays:', error));

    // Créer un groupe de clusters avec la configuration spécifiée
    markers = L.markerClusterGroup({
        maxClusterRadius: function (zoom) {
            return (zoom < 5.48) ? 80 : 20;
        }
    });

    map.addLayer(markers);
    // Ajouter le groupe de clusters à la carte
}

function clearAllSelect2() {
    const selectPratiques = document.getElementById('select2');
    selectPratiques.innerHTML = ''; // Effacer les options existantes

    // Ajouter une première option par défaut
    const defaultOption = document.createElement('option');
    defaultOption.value = ''; // Pas de valeur
    defaultOption.textContent = 'sélectionner une pratique'; // Texte de l'option par défaut
    defaultOption.selected = true; // Sélectionner cette option par défaut
    defaultOption.disabled = true; // Désactiver pour obliger un choix
    selectPratiques.appendChild(defaultOption);
}

function mappratique(datas){
    map.setView([16.8851072489, 2.3150724758], 5.48);
    var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    });

    var osmHOT = L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors, Tiles style by Humanitarian OpenStreetMap Team hosted by OpenStreetMap France'
    });

    var openTopoMap = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: 'Map data: © OpenStreetMap contributors, SRTM | Map style: © OpenTopoMap (CC-BY-SA)'
    });
    if (map) {
        // Si oui, retirer les clusters existants
        map.removeLayer(markers);   
        map.removeControl(layerControl);
    } else {
        // Si non, initialiser la carte avec les couches par défaut
        map = L.map('map', { minZoom: 5 // Définissez le niveau de zoom minimum ici 
        }).setView([16.8851072489, 2.3150724758], 5.48);
        osm.addTo(map); // Ajouter la couche par défaut à la carte // Ajouter la couche des villes par défaut à la carte
    }
    markers = L.markerClusterGroup(
        { 
            maxClusterRadius: function(zoom) { return (zoom < 5.48) ? 50 : 40; // Rayon du cluster plus grand pour les niveaux de zoom inférieurs 
            } 
        });
        datas.forEach(point => {
            const popupContent = `
                <div style="max-height: 400px; overflow-y: auto; text-align: center; padding: 10px; background-color: rgba(255, 255, 255, 0.8); border-radius: 8px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); min-width: 500px; max-width: 100%; width: 600px;">
                    <h4>${point.nomLocalite}</h4>
                    <div style="margin-top: 10px;">
                        <img src="${point.vedette_path || ''}" alt="Image de la pratique" style="max-width: 100%; height: auto; margin-top: 10px;" class="pratique-image" data-id="${point.pratique_id}" data-route="/details-pratiques/${point.pratique_id}">
                    </div>
                    <div style="margin-top: 10px;">
                        <h4 style="color: green;">Objectifs</h4>
                        <p>${point.objectif}</p>
                    </div>
                </div>
            `;
    
            const marker = L.marker([point.latitude, point.longitude])
                .bindPopup(popupContent, { 
                    maxWidth: 700, 
                    minWidth: 500, 
                    maxHeight: 300 
                });
    
            marker.on('mouseover', function (e) { 
                marker.bindTooltip(point.pratiqueLibelle, { 
                    permanent: false, direction: 'top', offset: L.point(0, -20), opacity: 0.8 
                }).openTooltip(); 
            });
    
            marker.on('mouseout', function (e) { marker.closeTooltip(); });
            markers.addLayer(marker);
        });
    
        // Ajouter les clusters à la carte
        map.addLayer(markers);
    
        // Ajouter un gestionnaire d'événements click sur les images
        document.addEventListener('click', function(event) {
            if(event.target.classList.contains('pratique-image')) {
                const route = event.target.getAttribute('data-route');
                window.location.href = route;
            }
        });
    
        // Ajouter des couches supplémentaires au contrôle de couches
        var baseLayers = {
            "OpenStreetMap": osm,
            "OSM Humanitarian": osmHOT,
            "OpenToMap": openTopoMap
        };
    
        layerControl = L.control.layers(baseLayers).addTo(map);
        //L.control.fullscreen().addTo(map);
}


document.getElementById('searchInput').addEventListener('input', function() {
    let filter = this.value.toLowerCase();
    let filtered = donnees.filter(pratique => 
        pratique.pratiqueLibelle.toLowerCase().includes(filter)
    );

    points.length = 0;  // Réinitialiser la liste des points
    const uniquePoints = new Set(); // Stocker les IDs uniques

    filtered.forEach(function(pratique) {
        const uniqueKey = `${pratique.pratique_id}-${pratique.localite_id}`; // Clé unique

        if (!uniquePoints.has(uniqueKey)) {
            uniquePoints.add(uniqueKey); // Marquer comme ajouté
            
            const point = {
                pratique_id: pratique.pratique_id,
                localite: pratique.localite_id,        // ID de la pratique
                localite_id: pratique.p0,
                nomLocalite: pratique.nomLocalite,    // ID de la localité
                longitude: pratique.longitude,       // Longitude
                latitude: pratique.latitude,         // Latitude
                pratiqueLibelle: pratique.pratiqueLibelle, // Libellé de la pratique
                description: pratique.description,   // Description
                objectif: pratique.objectif,         // Objectif
                vedette_path: pratique.vedette_path  // Vedette Path
            };

            points.push(point);
        }
    });

    mappratique(points); // Mettre à jour la carte
});

// Exécuter la fonction au chargement de la page
$(document).ready(function () {
    chargerPratiques();
    contours();
});


function chargerPratiques() {
    var resultat = document.getElementById('resultat');    
    $.ajax({
        url: "/init",  // L'URL de la route qui appelle la méthode `initialisemap`
        type: "GET",   // Méthode de requête HTTP
        beforeSend: function () {
            resultat.style.display = 'flex';
        },
        success: function (response) {
            if (response.status === "success") {
                var localiteParent = {};
                donnees = response.data;
                const uniquePoints = new Map(); // Utilisation d'une Map pour assurer l'unicité des points

                response.data.forEach(function(pratique) {
                    // Vérifier si le pays existe déjà dans l'objet localiteParent
                    if (!localiteParent[pratique.p0]) {
                        localiteParent[pratique.p0] = pratique.pays;
                    }

                    const key = `${pratique.pratique_id}-${pratique.localite_id}`; // Clé unique
                    if (!uniquePoints.has(key)) {
                        uniquePoints.set(key, {
                            pratique_id: pratique.pratique_id,
                            localite: pratique.localite_id,
                            localite_id: pratique.p0,
                            nomLocalite: pratique.nomLocalite,
                            longitude: pratique.longitude,
                            latitude: pratique.latitude,
                            pratiqueLibelle: pratique.pratiqueLibelle,
                            description: pratique.description,
                            objectif: pratique.objectif,
                            vedette_path: pratique.vedette_path
                        });
                    }
                });

                points = Array.from(uniquePoints.values()); // Convertir la Map en tableau
                
                populateSelect1(localiteParent);

                // Extraction des pratiques uniques pour la liste
                const pts = [];
                const ids = new Set();
                points.forEach(function(pratique) {
                    if (!ids.has(pratique.pratique_id)) {
                        ids.add(pratique.pratique_id);
                        pts.push({
                            pratique_id: pratique.pratique_id,
                            pratiqueLibelle: pratique.pratiqueLibelle,
                        });
                    }
                });

                initmap(points);
                resultat.style.display = 'none';
            } else {
                console.log("Erreur de chargement des pratiques.");
            }
        },
        error: function (xhr, status, error) {
            console.error("❌ Erreur AJAX :", error);
            resultat.style.display = 'none';
        }
    });
}

function showSelection(selectElement) {
    
    const parentId = selectElement.value; // Récupérer l'ID de la localité sélectionnée
    var resultat = document.getElementById('resultat'); // Élément pour afficher le chargement
    pays_id=parentId;
    const url = `/pays/${rub}/${srub}?parent_id=${parentId}`; // Construire l'URL de la requête AJAX

    $.ajax({
        url: url,
        type: "GET",
        beforeSend: function () {
            resultat.style.display = 'flex'; // Afficher l'indicateur de chargement
        },
        success: function (response) {
            if (!response.data || response.data.length === 0) {
                console.warn("Aucune donnée trouvée.");
                resultat.style.display = 'none';
                return;
            }

            var data = response.data;

            // Appliquer les filtres si les variables existent et ne sont pas nulles
            data = data.filter(pratique =>
                (!climat_id || pratique.climat_id == climat_id) &&
                (!sol_id || pratique.sol_id == sol_id) &&
                (!theme_id || pratique.theme_id == theme_id) &&
                (!domaine_id || pratique.domaine_id == domaine_id) &&
                (pratique.p0 == parentId) // Vérification de la correspondance avec parentId
            );

            var points = [];
            const uniquePoints = new Set();

            // Transformer les données en objets uniques
            data.forEach(pratique => {
                const uniqueKey = `${pratique.pratique_id}-${pratique.localite_id}`; // Clé unique
                if (!uniquePoints.has(uniqueKey)) {
                    uniquePoints.add(uniqueKey);
                    points.push({
                        pratique_id: pratique.pratique_id,
                        localite: pratique.localite_id,  // ID de la localité
                        localite_id: pratique.p0,
                        nomLocalite: pratique.nomLocalite,
                        longitude: pratique.longitude,
                        latitude: pratique.latitude,
                        pratiqueLibelle: pratique.pratiqueLibelle,
                        description: pratique.description,
                        objectif: pratique.objectif,
                        vedette_path: pratique.vedette_path
                    });
                }
            });

            // Mettre à jour la carte avec les nouveaux points
            initmap(points);

            // Mise à jour des sélecteurs
            updateSelectOptions(points);

            // Déplacer la carte sur la nouvelle position
            if (response.parent && response.parent.longitude && response.parent.latitude) {
                map.setView([response.parent.latitude, response.parent.longitude], 6.48);
            }
        },
        error: function (xhr, status, error) {
            console.error("❌ Erreur AJAX :", error);
        },
        complete: function () {
            resultat.style.display = 'none'; // Cacher l'indicateur de chargement une fois terminé
        }
    });
}

/**
 * Met à jour les options des sélecteurs
 */
function updateSelectOptions(points) {
    const ptss = [];
    const idss = new Set();
    const pts = [];
    const ids = new Set();

    points.forEach(pratique => {
        if (!idss.has(pratique.localite)) {
            idss.add(pratique.localite);
            ptss.push({ pratique_id: pratique.localite, pratiqueLibelle: pratique.nomLocalite });
        }
        if (!ids.has(pratique.pratique_id)) {
            ids.add(pratique.pratique_id);
            pts.push({ pratique_id: pratique.pratique_id, pratiqueLibelle: pratique.pratiqueLibelle });
        }
    });

    populateSelect2(ptss);
}

function showClimatSelection(selectElement) {
    const parentId = selectElement.value;
    climat_id=parentId;
    var resultat = document.getElementById('resultat'); // Élément pour afficher le chargement
    // Construire l'URL de la requête
    const url = `/init`;
    $.ajax({
        url: url,
        type: "GET",
        beforeSend: function () {
            resultat.style.display = 'flex'; // Afficher l'indicateur de chargement
        },
        success: function (response) {
            if (response.success === "true") {
                var data = response.data;
                data = data.filter(pratique =>
                    (!pays_id || pratique.p0 == pays_id) &&
                    (!localite_id || pratique.localite_id == localite_id) &&
                    (!sol_id || pratique.sol_id == sol_id) &&
                    (!theme_id || pratique.theme_id == theme_id) &&
                    (!domaine_id || pratique.domaine_id == domaine_id) &&
                    (pratique.climat_id == parentId) // Vérification de la correspondance avec parentId
                );
                var points = [];
            const uniquePoints = new Set();

            // Transformer les données en objets uniques
            data.forEach(pratique => {
                const uniqueKey = `${pratique.pratique_id}-${pratique.localite_id}`; // Clé unique
                if (!uniquePoints.has(uniqueKey)) {
                    uniquePoints.add(uniqueKey);
                    points.push({
                        pratique_id: pratique.pratique_id,
                        localite: pratique.localite_id,  // ID de la localité
                        localite_id: pratique.p0,
                        nomLocalite: pratique.nomLocalite,
                        longitude: pratique.longitude,
                        latitude: pratique.latitude,
                        pratiqueLibelle: pratique.pratiqueLibelle,
                        description: pratique.description,
                        objectif: pratique.objectif,
                        vedette_path: pratique.vedette_path
                    });
                }
            });

            // Mettre à jour la carte avec les nouveaux points
            initmap(points);

            // Mise à jour des sélecteurs
            updateSelectOptions(points);
            map.setView([16.8851072489, 2.3150724758], 5.48);
            }
        },
        error: function (xhr, status, error) {
            console.error("❌ Erreur AJAX :", error);
        },
        complete: function () {
            resultat.style.display = 'none'; // Cacher l'indicateur de chargement une fois terminé
        }
    });
    clearAllSelect2();
}


var data = {};
let points = [];
let map;  // Variable globale pour garder une référence à la carte 
let markers = L.markerClusterGroup();
let layerControl =L.control.layers();
let fullscreenControl = null;
let climat=false;
let domaine=false;
let sol=false;
let climat_id=null;
let sol_id=null;
let domaine_id=null;
let theme_id=null;
let pays_id=null;
let localite_id=null;
var donnees={};


function populateSelect2(datas) {
    const selectPratiques = document.getElementById('select2');
    selectPratiques.innerHTML = ''; // Effacer les options existantes

    // Ajouter une première option par défaut
    const defaultOption = document.createElement('option');
    defaultOption.value = 'selected disabled '; // Pas de valeur
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
function populatedomaine(datas) {
    const selectPratiques = document.getElementById('select_domaine');
    selectPratiques.innerHTML = ''; // Effacer les options existantes

    // Ajouter une première option par défaut
    const defaultOption = document.createElement('option');
    defaultOption.value = 'selected disabled '; // Pas de valeur
    defaultOption.textContent = 'sélectionner un domaine'; // Texte de l'option par défaut
    defaultOption.selected = true; // Sélectionner cette option par défaut
    defaultOption.disabled = true; // Désactiver pour obliger un choix
    selectPratiques.appendChild(defaultOption);

    // Ajouter les options des pratiques
    datas.forEach(pratique => {
        const option = document.createElement('option');
        option.value = pratique.domaine_id; // Utiliser l'identifiant de la pratique
        option.textContent = pratique.domaineLibelle; // Utiliser le libellé de la pratique
        selectPratiques.appendChild(option);
    });
}

function populateSelect1(datas) {
    const selectDatas = document.getElementById('select1');
    selectDatas.innerHTML = ''; // Effacer les options existantes

    // Ajouter une première option par défaut
    const defaultOption = document.createElement('option');
    defaultOption.value = 'selected disabled '; // Pas de valeur
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

function initmap(datas) {
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
        map.removeLayer(markers);
        map.removeControl(layerControl);
        if (fullscreenControl) {
            map.removeControl(fullscreenControl);
            fullscreenControl = null;
        }
    } else {
        map = L.map('map', { minZoom: 5 }).setView([16.8851072489, 2.3150724758], 5.48);
        osm.addTo(map);
    }

    markers = L.markerClusterGroup({
        maxClusterRadius: function(zoom) { return (zoom < 5.48) ? 50 : 40; }
    });

    datas.forEach(point => {
        if (point.pratiqueLibelle && point.objectif && point.latitude && point.longitude) {
            function truncateText(text, maxLength) {
                if (!text) return "";
                return text.length > maxLength ? text.substring(0, maxLength) + "..." : text;
            }

            const popupContent = `
                <div style="width: 100%; height: 100%; text-align: left; font-family: 'Arial', sans-serif;  border-radius: 5px;">
                    <div >
                        <img src="${point.vedette_path || ''}" 
                             alt="Image de la pratique" 
                             style="width: 100%; height: auto; cursor:pointer;  border-radius: 8px; border: 2px solid #ecf0f1; box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1);" 
                             class="pratique-image" 
                             data-id="${point.pratique_id}" 
                             data-route="/details-pratiques/${point.pratique_id}">
                    </div>
                    <h3 style="color: #2c3e50; font-size: 16px !important;  cursor:pointer; font-weight: bold;" class="libelle" data-id="${point.pratique_id}" data-route="/details-pratiques/${point.pratique_id}">
                        ${point.pratiqueLibelle}
                    </h3>
                    <div style="text-align: left;">
                        <p style="color: rgb(120, 130, 140); font-size: 14px !important; line-height: 1.2 !important; margin: 0; text-align: justify; display: block !important;">
                            ${truncateText(point.objectif, 125)}
                        </p>
                    </div>
                </div>
            `;
            const marker = L.marker([point.latitude, point.longitude])
                .bindPopup(popupContent, { maxWidth: 300, minWidth: 200 });

            marker.on('mouseover', function (e) {
                marker.bindTooltip('<b>' + point.pratiqueLibelle + '</b>', { permanent: false, direction: 'top', offset: L.point(0, -20), opacity: 0.8 }).openTooltip();
            });

            marker.on('mouseout', function (e) { marker.closeTooltip(); });

            markers.addLayer(marker);
        }
    });

    map.addLayer(markers);

    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('pratique-image')) {
            const route = event.target.getAttribute('data-route');
            window.location.href = route;
        }
    });
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('libelle')) {
            const route = event.target.getAttribute('data-route');
            window.location.href = route;
        }
    });

    var baseLayers = {
        "OpenStreetMap": osm,
        "OSM Humanitarian": osmHOT,
        "OpenToMap": openTopoMap
    };

    layerControl = L.control.layers(baseLayers).addTo(map);

    // Toujours recréer le contrôle fullscreen pour éviter les doublons
    if (fullscreenControl) {
        map.removeControl(fullscreenControl);
        fullscreenControl = null;
    }
    fullscreenControl = L.control.fullscreen().addTo(map);
}

function contours() {
    map = L.map('map', { minZoom: 5 // Définissez le niveau de zoom minimum ici 
    }).setView([16.8851072489, 2.3150724758], 5.48);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        opacity: 1
    }).addTo(map);

    // Charger le fichier JSON contenant les limites des pays
    fetch('/data/Pays_cilss.json')
        .then(response => response.json())
        .then(data => {
            // Ajouter les limites des pays en tant que polygones
            L.geoJSON(data, {
                style: {
                    color: 'blue',
                    weight: 1,
                    opacity: 1,
                    fillColor: '#5f6a6a',
                    fillOpacity: 0.3
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



function showSelection(selectElement) {

    document.querySelector('.filters-container').classList.remove('active');
    document.querySelector('.map-container').style.display = 'block';
    verif();
    const parentId = selectElement.value; // Récupérer l'ID de la localité sélectionnée
    var resultat = document.getElementById('resultat');
    pays_id=parentId; // Élément pour afficher le chargement
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
function updateSelectOptions(data) {
    const ptss = [];
    const idss = new Set();
    const pts = [];
    const ids = new Set();

    data.forEach(pratique => {
        if (pratique.pratiqueLibelle && pratique.nomLocalite && pratique.localite) { // Vérifiez que nomLocalite et localite existent
            if (!idss.has(pratique.localite)) {
                idss.add(pratique.localite);
                ptss.push({ pratique_id: pratique.localite, pratiqueLibelle: pratique.nomLocalite });
            }
        }

        if (pratique.pratiqueLibelle && pratique.pratiqueLibelle && pratique.pratique_id) { // Vérifiez que pratiqueLibelle et pratique_id existent
            if (!ids.has(pratique.pratique_id)) {
                ids.add(pratique.pratique_id);
                pts.push({ pratique_id: pratique.pratique_id, pratiqueLibelle: pratique.pratiqueLibelle });
            }
        }
    });

    populateSelect2(ptss);
}



function showClimatSelection(selectElement) {
    document.querySelector('.filters-container').classList.remove('active');
    document.querySelector('.map-container').style.display = 'block';
    verif();
    const parentId = selectElement.value;
    climat_id = parentId; // Mettre à jour la variable climat_id

    var resultat = document.getElementById('resultat'); // Élément de chargement
    const url = `/init`; // URL de la requête AJAX

    $.ajax({
        url: url,
        type: "GET",
        beforeSend: function () {
            resultat.style.display = 'flex'; // Afficher le chargement
        },
        success: function (response) {
            if (response.status === "success" && response.data) {
                let data = response.data.filter(pratique =>
                    (!pays_id || pratique.p0 == pays_id) &&
                    (!localite_id || pratique.localite_id == localite_id) &&
                    (!sol_id || pratique.sol_id == sol_id) &&
                    (!theme_id || pratique.theme_id == theme_id) &&
                    (!domaine_id || pratique.domaine_id == domaine_id) &&
                    (pratique.climat_id == parentId) // Vérification avec parentId
                );

                let pointss = [];
                const uniquePoints = new Set();

                // Transformer les données en objets uniques
                data.forEach(pratique => {
                    const uniqueKey = `${pratique.pratique_id}-${pratique.localite_id}`;
                    if (!uniquePoints.has(uniqueKey)) {
                        uniquePoints.add(uniqueKey);
                        pointss.push({
                            pratique_id: pratique.pratique_id,
                            localite: pratique.localite_id, // ID de la localité
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

                // Mise à jour de la carte et des sélecteurs
                initmap(pointss);
                updateSelectOptions(pointss);
                clearAllSelect2();
                // Déplacer la carte si les coordonnées sont valides
                if (typeof map !== "undefined" && map.setView) {
                    map.setView([16.8851072489, 2.3150724758], 5.48);
                } else {
                    console.warn("⚠️ La carte (map) n'est pas définie.");
                }
            } else {
                console.warn("⚠️ Aucune donnée trouvée dans la réponse.");
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

function showSolSelection(selectElement) {
    document.querySelector('.filters-container').classList.remove('active');
    document.querySelector('.map-container').style.display = 'block';
    verif();
    const parentId = selectElement.value;
    sol_id = parentId; // Mettre à jour la variable climat_id

    var resultat = document.getElementById('resultat'); // Élément de chargement
    const url = `/init`; // URL de la requête AJAX

    $.ajax({
        url: url,
        type: "GET",
        beforeSend: function () {
            resultat.style.display = 'flex'; // Afficher le chargement
        },
        success: function (response) {
            if (response.status === "success" && response.data) {
                let data = response.data.filter(pratique =>
                    (!pays_id || pratique.p0 == pays_id) &&
                    (!localite_id || pratique.localite_id == localite_id) &&
                    (!climat_id || pratique.climat_id == climat_id) &&
                    (!theme_id || pratique.theme_id == theme_id) &&
                    (!domaine_id || pratique.domaine_id == domaine_id) &&
                    (pratique.sol_id == parentId) // Vérification avec parentId
                );

                let pointss = [];
                const uniquePoints = new Set();

                // Transformer les données en objets uniques
                data.forEach(pratique => {
                    const uniqueKey = `${pratique.pratique_id}-${pratique.localite_id}`;
                    if (!uniquePoints.has(uniqueKey)) {
                        uniquePoints.add(uniqueKey);
                        pointss.push({
                            pratique_id: pratique.pratique_id,
                            localite: pratique.localite_id, // ID de la localité
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

                // Mise à jour de la carte et des sélecteurs
                initmap(pointss);
                updateSelectOptions(pointss);
                clearAllSelect2();

                // Déplacer la carte si les coordonnées sont valides
                if (typeof map !== "undefined" && map.setView) {
                    map.setView([16.8851072489, 2.3150724758], 5.48);
                } else {
                    console.warn("⚠️ La carte (map) n'est pas définie.");
                }
            } else {
                console.warn("⚠️ Aucune donnée trouvée dans la réponse.");
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

function showdomaineSelection(selectElement) {
    document.querySelector('.filters-container').classList.remove('active');
    document.querySelector('.map-container').style.display = 'block';
    verif();
    const parentId = selectElement.value;
    console.log(parentId);
    domaine_id = parentId; // Mettre à jour la variable climat_id

    var resultat = document.getElementById('resultat'); // Élément de chargement
    const url = `/init`; // URL de la requête AJAX

    $.ajax({
        url: url,
        type: "GET",
        beforeSend: function () {
            resultat.style.display = 'flex'; // Afficher le chargement
        },
        success: function (response) {
            if (response.status === "success" && response.data) {
                let data = response.data.filter(pratique =>
                    (!pays_id || pratique.p0 == pays_id) &&
                    (!localite_id || pratique.localite_id == localite_id) &&
                    (!climat_id || pratique.climat_id == climat_id) &&
                    (!theme_id || pratique.theme_id == theme_id) &&
                    (!sol_id || pratique.sol_id == sol_id) &&
                    (pratique.domaine_id == parentId) // Vérification avec parentId
                );

                let pointss = [];
                const uniquePoints = new Set();

                // Transformer les données en objets uniques
                data.forEach(pratique => {
                    const uniqueKey = `${pratique.pratique_id}-${pratique.localite_id}`;
                    if (!uniquePoints.has(uniqueKey)) {
                        uniquePoints.add(uniqueKey);
                        pointss.push({
                            pratique_id: pratique.pratique_id,
                            localite: pratique.localite_id, // ID de la localité
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

                // Mise à jour de la carte et des sélecteurs
                initmap(pointss);
                updateSelectOptions(pointss);
                clearAllSelect2();

                // Déplacer la carte si les coordonnées sont valides
                if (typeof map !== "undefined" && map.setView) {
                    map.setView([16.8851072489, 2.3150724758], 5.48);
                } else {
                    console.warn("⚠️ La carte (map) n'est pas définie.");
                }
            } else {
                console.warn("⚠️ Aucune donnée trouvée dans la réponse.");
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

async function showthemeSelection(selectElement) {
    document.querySelector('.filters-container').classList.remove('active');
    document.querySelector('.map-container').style.display = 'block';
    verif();

    const parentId = selectElement.value;
    theme_id = parentId; // Mettre à jour la variable theme_id

    var resultat = document.getElementById('resultat'); // Élément de chargement
    const url1 = `/init`; // Première requête
    const url2 = `/showtheme?theme_id=${theme_id}`; // Deuxième requête avec theme_id

    try {
        resultat.style.display = 'flex'; // Afficher le chargement

        // Exécuter les deux requêtes en parallèle
        const [response1, response2] = await Promise.all([
            $.ajax({ url: url1, type: "GET" }),
            $.ajax({ url: url2, type: "GET" })
        ]);

        // 🔹 Gérer la première réponse (mise à jour de la carte)
        if (response1.status === "success" && response1.data) {
            let data = response1.data.filter(pratique =>
                (!pays_id || pratique.p0 == pays_id) &&
                (!localite_id || pratique.localite_id == localite_id) &&
                (!climat_id || pratique.climat_id == climat_id) &&
                (!domaine_id || pratique.domaine_id == domaine_id) &&
                (!sol_id || pratique.sol_id == sol_id) &&
                (pratique.theme_id == parentId)
            );

            let pointss = [];
            const uniquePoints = new Set();

            data.forEach(pratique => {
                const uniqueKey = `${pratique.pratique_id}-${pratique.localite_id}`;
                if (!uniquePoints.has(uniqueKey)) {
                    uniquePoints.add(uniqueKey);
                    pointss.push({
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

            initmap(pointss);
            updateSelectOptions(pointss);
            clearAllSelect2();

            if (typeof map !== "undefined" && map.setView) {
                map.setView([16.8851072489, 2.3150724758], 5.48);
            } else {
                console.warn("⚠️ La carte (map) n'est pas définie.");
            }
        } else {
            console.warn("⚠️ Aucune donnée trouvée dans la réponse 1.");
        }

        // 🔹 Gérer la deuxième réponse (showtheme)
        if (response2.status === "success" && response2.domaines) {
            populatedomaine(response2.domaines);
        } else {
            console.warn("⚠️ Aucune donnée trouvée dans la réponse 2.");
        }

    } catch (error) {
        console.error("❌ Erreur AJAX :", error);
    } finally {
        resultat.style.display = 'none'; // Cacher l'indicateur de chargement une fois terminé
    }
}



function clearAllSelect2() {
    const selectPratiques = document.getElementById('select2');
    selectPratiques.innerHTML = ''; // Effacer les options existantes

    // Ajouter une première option par défaut
    const defaultOption = document.createElement('option');
    defaultOption.value = 'selected disabled '; // Pas de valeur
    defaultOption.textContent = 'sélectionner une localité'; // Texte de l'option par défaut
    defaultOption.selected = true; // Sélectionner cette option par défaut
    defaultOption.disabled = true; // Désactiver pour obliger un choix
    selectPratiques.appendChild(defaultOption);
}


function showSelection2(selectElement) {
    document.querySelector('.filters-container').classList.remove('active');
    document.querySelector('.map-container').style.display = 'block';
    verif();
    const parentId = selectElement.value; // Récupérer l'ID de la localité sélectionnée
    var resultat = document.getElementById('resultat');
    localite_id=parentId; // Élément pour afficher le chargement
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
                (!pays_id || pratique.p0 == pays_id) &&
                (!climat_id || pratique.climat_id == climat_id) &&
                (!sol_id || pratique.sol_id == sol_id) &&
                (!theme_id || pratique.theme_id == theme_id) &&
                (!domaine_id || pratique.domaine_id == domaine_id) &&
                (pratique.localite_id == parentId) // Vérification de la correspondance avec parentId
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
        map.removeLayer(markers);   
        map.removeControl(layerControl);
        if (fullscreenControl) {
            map.removeControl(fullscreenControl);
            fullscreenControl = null;
        }
    } else {
        map = L.map('map', { minZoom: 5 }).setView([16.8851072489, 2.3150724758], 5.48);
        osm.addTo(map);
    }

    markers = L.markerClusterGroup({
        maxClusterRadius: function(zoom) { return (zoom < 5.48) ? 50 : 40; }
    });

    datas.forEach(point => {
        if (point.pratiqueLibelle && point.objectif && point.latitude && point.longitude) {
            function truncateText(text, maxLength) {
                if (!text) return "";
                return text.length > maxLength ? text.substring(0, maxLength) + "..." : text;
            }

            const popupContent = `
                <div style="width: 100%; height: 100%; text-align: left; font-family: 'Arial', sans-serif;  border-radius: 5px;">
                    <div >
                        <img src="${point.vedette_path || ''}" 
                             alt="Image de la pratique" 
                             style="width: 100%; height: auto; cursor:pointer;  border-radius: 8px; border: 2px solid #ecf0f1; box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1);" 
                             class="pratique-image" 
                             data-id="${point.pratique_id}" 
                             data-route="/details-pratiques/${point.pratique_id}">
                    </div>
                    <h3 style="color: #2c3e50; font-size: 16px !important;  cursor:pointer; font-weight: bold;" class="libelle" data-id="${point.pratique_id}" data-route="/details-pratiques/${point.pratique_id}">
                        ${point.pratiqueLibelle}
                    </h3>
                    <div style="text-align: left;">
                        <p style="color: rgb(120, 130, 140); font-size: 14px !important; line-height: 1.2 !important; margin: 0; text-align: justify; display: block !important;">
                            ${truncateText(point.objectif, 125)}
                        </p>
                    </div>
                </div>
            `;

            const marker = L.marker([point.latitude, point.longitude])
                .bindPopup(popupContent, { maxWidth: 300, minWidth: 200 });

            marker.on('mouseover', function (e) {
                marker.bindTooltip('<b>' + point.pratiqueLibelle + '</b>', { permanent: false, direction: 'top', offset: L.point(0, -20), opacity: 0.8 }).openTooltip();
            });

            marker.on('mouseout', function (e) { marker.closeTooltip(); });

            markers.addLayer(marker);
        }
    });

    map.addLayer(markers);

    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('pratique-image')) {
            const route = event.target.getAttribute('data-route');
            window.location.href = route;
        }
    });
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('libelle')) {
            const route = event.target.getAttribute('data-route');
            window.location.href = route;
        }
    });

    var baseLayers = {
        "OpenStreetMap": osm,
        "OSM Humanitarian": osmHOT,
        "OpenToMap": openTopoMap
    };
    layerControl = L.control.layers(baseLayers).addTo(map);

    // Toujours recréer le contrôle fullscreen pour éviter les doublons
    if (fullscreenControl) {
        map.removeControl(fullscreenControl);
        fullscreenControl = null;
    }
    fullscreenControl = L.control.fullscreen().addTo(map);
}

document.getElementById('searchInput').addEventListener('input', function() {
    let filter = this.value.toLowerCase();

    let filtered = donnees.filter(pratique => 
        pratique && pratique.pratiqueLibelle && pratique.pratiqueLibelle.toLowerCase().includes(filter)
    );

    points.length = 0;  // Réinitialiser la liste des points
    const uniquePoints = new Set(); // Stocker les IDs uniques

    filtered.forEach(function(pratique) {
        if (!pratique) return; // Vérification supplémentaire

        const uniqueKey = `${pratique.pratique_id}-${pratique.localite_id}`; // Clé unique

        if (!uniquePoints.has(uniqueKey)) {
            uniquePoints.add(uniqueKey); // Marquer comme ajouté
            
            const point = {
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

function verif() {
    const icon2 = document.getElementById('icon2');
    const filters = document.querySelector('.filters-container');
        const mapContainer = document.querySelector('.map-container');
    if (filters.classList.contains('active')) {
        icon2.classList.remove('fas', 'fa-filter'); // Supprime l'icône de filtre
        icon2.classList.add('fas', 'fa-map-location-dot'); // Ajoute l'icône de localisation
        icon2.style.color=" #ec7063";
    } else {
        icon2.classList.remove('fas', 'fa-map-location-dot'); // Supprime l'icône de localisation
        icon2.classList.add('fas', 'fa-filter'); // Remet l'icône de filtre
        icon2.style.color="white";
    }
}

        document.querySelector('.search-icon').addEventListener('click', function() {
        const filters = document.querySelector('.filters-container');
        const mapContainer = document.querySelector('.map-container');
        
        filters.classList.toggle('active'); // Affiche ou cache les filtres
        mapContainer.style.display = filters.classList.contains('active') ? 'none' : 'block'; // Cache ou affiche la carte
        verif();
        });
        const icon = document.getElementById('rechercherp');
        icon.addEventListener('click', function() {
            document.querySelector('.filters-container').classList.remove('active');
            document.querySelector('.map-container').style.display = 'block';
        });

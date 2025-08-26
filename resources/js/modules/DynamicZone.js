export function DynamicZone() {
    const zonesContainer = $("#zones-container");
    const zonesContainer2 = $("#zonesp-container");
    const addBtn = $("#addZone");
    const addBtn2 = $("#addZonep");
    const form = document.getElementById("form-pratique");
    const zones = document.querySelectorAll(".zone-container");
    const zonesp = document.querySelectorAll(".zonep-container");
    const background = "#ececec";
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const zones = document.querySelectorAll(".zone-container");
        if (!zones || zones.length <= 0) {
            alert("Veillez renseigner au moins une zone");
        } else {
            if (form.checkValidity()) {
                form.submit();
            } else {
                alert(
                    "Le formulaire contient des erreurs. Veuillez les corriger."
                );
            }
        }
    });

    __addZone(addBtn, 1, zonesContainer);
    // __removeZone("removeZone", "zone-container");
    __filleSelect("pays", "zone-container", "localite", 1);

    __addZone(addBtn2, 2, zonesContainer2);
    // __removeZone("removeZonep", "zonep-container");
    __filleSelect("paysp", "zonep-container", "localitep", 2);

    function __addZone(btnElement, zoneType, container) {
        btnElement.off("click").on("click", function () {
        __displayForm(container, "append", zoneType);
    });
   }

    $(document).on('click', '.removeZone', function (e) {
        // __addRemovedZoneHiddenInput(
        //     this,
        //     '.zone-container',
        //     '.localite',
        //     removedZonesContainer,
        //     'removed_zones',
        //     'initial_zones',
        // );
        
        __removeZone2(e, 'zone-container');
    })

    $(document).on('click', '.removeZonep', function (e) {
        console.log('clickded');
    
        // __addRemovedZoneHiddenInput(
        //     this,
        //     '.zonep-container',
        //     '.localitep',
        //     removedZonespContainer,
        //     'removed_zonesp',
        //     'initial_zonesp',
        // );
    
        __removeZone2(e, 'zonep-container'); // Supprimer la zone
    });

       
    __validateAllZones(zones);
    __validateAllZones2(zonesp);
    
    $(document).on('change', '.localite', function () {
        const zone = $(this).closest('.zone-container')[0];
        __validateZone(zone);
    });
    $(document).on('change', '.localitep', function () {
        const zonep = $(this).closest('.zonep-container')[0];
        __validateZone(zonep);
    });

    // function __removeZone(btnClass, containerClass) {
    //     $(document).on("click", `.${btnClass}`, function (event) {
    //         event.preventDefault();
    //         event.stopPropagation();
    //         let zoneFormToRemove = $(this).closest(`.${containerClass}`);
    //         if (zoneFormToRemove.length) {
    //             zoneFormToRemove.remove();
    //         }
    //     });
    // }

    // function __removeZone2(event, containerClass) {
    //         event.preventDefault();
    //         event.stopPropagation();
    //         let zoneFormToRemove = $(this).closest(`.${containerClass}`);
    //         if (zoneFormToRemove.length) {
    //             zoneFormToRemove.remove();
    //         }
    // }

    function __filleSelect(selectClass, containerClass, targetClass, typeZone) {
        $(document).on("change", `.${selectClass}`, function () {
            let paysId = $(this).val();
            let nextSelect = $(this)
                .closest(`.${containerClass}`)
                .find(`.${targetClass}`);
            __displayForm(nextSelect, "replace", typeZone, paysId);
        });
    }

    function __displayForm(
        container,
        mode = "append",
        typeZone,
        localiteId = null
    ) {
        let loader = document.getElementById("loader");
        loader.style.display = "block";
        let url = localiteId
            ? `/formulaire/${typeZone}/${localiteId}`
            : `/formulaire/${typeZone}`;

        fetch(url)
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Unknown error");
                }
                return response.json();
            })
            .then((data) => {
                if (data && data.success) {
                    let $container = $(container);
                    let htmlContent = data.html.original
                        ? data.html.original.html
                        : data.html;
                    if (mode === "replace") {
                        $container.html(htmlContent);
                    } else if (mode === "append") {
                        $container.append(htmlContent);
                    }
                    __handleAddBtnClick($container);
                    $('.js-example-basic-single').select2();
                }
            })
            .catch((error) => {
                // console.error(error);
                alert(
                    "OOps! une erreur s'est produite. Veuiller recharger la page et ressayer"
                );
            })
            .finally(() => {
                loader.style.display = "none";
            });
    }

    function __isAllSelectFilled(container) {
        let selectElements = $(container).find("select").filter("[required]");
        let allFilled = true;
        selectElements.each(function (index) {
            let value = $(this).val() ? $(this).val().trim() : "";
            if (value === "") {
                allFilled = false;
                return false; // Break out of the loop early
            }
        });
        return allFilled;
    }
    function __handleAddBtnClick(container) {
        if (__isAllSelectFilled(container)) {
            addBtn.prop("disabled", false); // Enable add button
        } else {
            addBtn.prop("disabled", true);
        }
    }

    function __validateZone(zone) {
        if (!zone) return;
        const selects = zone.querySelectorAll('select');
        const allValid = Array.from(selects).every((select) => select.checkValidity());
        zone.style.backgroundColor = allValid ? background : "";
    }

    function __validateZone2(zone) {
        if (!zone) return;
        
        const selects = zone.querySelectorAll('select');
        const pairs = [];
        for (let i = 0; i < selects.length; i += 2) {
            pairs.push([selects[i], selects[i + 1]]);
        }
        const allValid = pairs.every(([select1, select2]) => {
            return select1.value && select2.value && select1.checkValidity() && select2.checkValidity();
        });
        zone.style.backgroundColor = allValid ? background : "";
    }
    
    
    function __validateAllZones(zones) {
        zones.forEach(__validateZone);
    }
    function __validateAllZones2(zones) {
        zones.forEach(__validateZone2);
    }

    function __addRemovedZoneHiddenInput(source, zoneContainerClass, targetClass, hiddenContainer, hiddenInputName, initialInputName) {
        // Trouver le conteneur parent
        const zoneContainer = $(source).closest(zoneContainerClass);
    
        if (!zoneContainer.length) {
            // console.error("Zone container introuvable.");
            return;
        }
    
        // Trouver la valeur de l'élément cible
        const targetElement = zoneContainer.find(`select${targetClass}`);
        if (!targetElement.length) {
            // console.error("Élément cible introuvable dans le conteneur.");
            return;
        }
    
        const val = targetElement.val(); // Utiliser .val() pour jQuery
        if (!val) {
            // console.error("Valeur non trouvée pour l'élément cible.");
            return;
        }
    
        // Construire une liste des valeurs initiales
        const initInputs = document.querySelectorAll(`input[name="${initialInputName}[]"]`);
        const initValues = Array.from(initInputs).map(input => input.value);
    
        // Si la valeur existe dans les valeurs initiales
        if (initValues.includes(val)) {
            // Vérifier si un champ hidden existe déjà
            const existingHidden = hiddenContainer.querySelector(`input[type="hidden"][value="${val}"][name="${hiddenInputName}[]"]`);

            if (!existingHidden) {
                // Créer un champ hidden
                const newHiddenInput = document.createElement('input');
                newHiddenInput.type = 'hidden';
                newHiddenInput.name = `${hiddenInputName}[]`;
                newHiddenInput.value = val;
    
                // Ajouter le champ hidden au conteneur
                hiddenContainer.appendChild(newHiddenInput);
            }
        }
    }
    
    
    
    function __removeZone2(event, containerClass) {
        event.preventDefault();
        event.stopPropagation();
    
        // Trouver la zone à supprimer
        const zoneFormToRemove = $(event.currentTarget).closest(`.${containerClass}`);
        if (zoneFormToRemove.length) {
            zoneFormToRemove.remove();
        }
    }

}

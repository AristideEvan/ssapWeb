/* <input type="checkbox" data-initial="{{ $item->attribute ? $item->pratique_id : '' }}" class="item-checkbox" name="selected_items[]"
value="{{ $item->id }}" {{ $item->attribute ? 'checked' : '' }}> 

const actionForm = new Form({
   checkboxesSelector: '.item-checkbox',
   initialDataKey: 'initial',
   loaderSelector: '#publique-loader',
   endpoint: '/update-items',
  action: 'action', // backend methode
   autoProcess: false,
 });

 document.querySelector('#itemButton').addEventListener('click', () => {
    actionForm.massAction();
});

*/

export class Form {
    constructor(config) {
        this.checkboxesSelector = config.checkboxesSelector;
        this.initialDataKey = config.initialDataKey;
        this.loaderSelector = config.loaderSelector;
        this.endpoint = config.endpoint;
        this.action = config.action;
        this.autoProcess = config.autoProcess || false;

        this.loader = document.querySelector(this.loaderSelector);

        if (this.autoProcess) {
            this.setupAutoProcess();
        }
    }

    // Fonction pour récupérer les valeurs sélectionnées
    getSelectedValues(selector) {
        return Array.from(document.querySelectorAll(`${selector}:checked`)).map(checkbox => checkbox.value);
    }

    // Fonction pour obtenir les valeurs initiales
    getInitialDataValues(name) {
        const rows = document.querySelectorAll(`[data-${name}]`);
        const values = [];
        rows.forEach(row => {
            const value = row.getAttribute(`data-${name}`);
            if (value) {
                values.push(value);
            }
        });
        return values;
    }

    // Fonction pour obtenir les valeurs non sélectionnées
    getUnselectedValues() {
        const initialValues = this.getInitialDataValues(this.initialDataKey);
        const selectedValues = this.getSelectedValues(this.checkboxesSelector);
        return initialValues.filter(val => !selectedValues.includes(val));
    }

    // Fonction pour obtenir les nouvelles valeurs
    getNewValues() {
        const initialValues = this.getInitialDataValues(this.initialDataKey);
        const selectedValues = this.getSelectedValues(this.checkboxesSelector);
        return selectedValues.filter(val => !initialValues.includes(val));
    }

    // Afficher le loader
    showLoader() {
        if (this.loader) this.loader.style.display = 'block';
    }

    // Cacher le loader
    hideLoader() {
        if (this.loader) this.loader.style.display = 'none';
    }

    // Envoi de la requête AJAX pour mettre à jour les valeurs
    massActions(moreData = {}, callback = null) {
        const unselectedValues = this.getUnselectedValues();
        const newValues = this.getNewValues();

        if (this.action && (unselectedValues.length > 0 || newValues.length > 0)) {
            this.showLoader();
            const data = JSON.stringify({
                unselected_values: unselectedValues,
                new_values: newValues,
                action: this.action,
                ...moreData
            });
            xlab.Http.ajax(
                this.endpoint,
                {
                    body: data,
                },
                (responseData) => {
                    console.log('from massActions', responseData);
                    if (callback) {
                        callback(responseData);
                    }
                    this.hideLoader();
                }
            );
        } else {
            console.log('Aucune sélection ou action définie.');
        }
    }

    setupAutoProcess() {
        const checkboxes = document.querySelectorAll(this.checkboxesSelector);
        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', () => this.massActions());
        });
    }

    serializeForm(formSelector) {
        const form = document.querySelector(formSelector);
        if (!form) return {};

        const formData = new FormData(form);
        const serializedData = {};
        
        formData.forEach((value, key) => {
            if (serializedData[key]) {
                serializedData[key] = [].concat(serializedData[key], value);
            } else {
                serializedData[key] = value;
            }
        });

        return serializedData;
    }
}

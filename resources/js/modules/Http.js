export class Http {
    ajax(route, userConfig = {}, onSuccess = () => {}, onError = () => {}, onFinally = () => {}) {
        // Configuration par défaut
        const defaultConfig = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({}),
        };

        const mergedConfig = {
            ...defaultConfig,
            ...userConfig,
            headers: {
                ...defaultConfig.headers,
                ...(userConfig.headers || {}),
            },
        };

        fetch(route, mergedConfig)
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then((data) => {
                onSuccess(data);
            })
            .catch((error) => {
                onError(error);
            })
            .finally(() => {
                onFinally();
            });
    }

    
}

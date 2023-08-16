import { parseErrors } from "./utils";

export default function api({ token = null } = {}) {
    const instance = axios.create();

    instance.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    instance.defaults.headers.common['Accept'] = 'application/json';

    if(token !== null) {
        instance.headers.common['Authorization'] = `Bearer ${token}`;
    }

    instance.interceptors.response.use(response => Promise.resolve(response.data), error => {
        const { response } = error;

        if(response.status === 401) return Promise.reject({ status: 401, errors: ['Unauthorized']});

        if(response.status === 422) {
            let errors = response?.data?.errors;
            return Promise.reject({ status: 422, errors: parseErrors(errors) });
        }

        if(response.status === 500) {
            return Promise.reject({ status: 500, errors: [response?.data?.message || 'Oups'] });
        }

        return Promise.reject({ status: response.status, errors: ['Oups!'] });
    });

    return instance;
}
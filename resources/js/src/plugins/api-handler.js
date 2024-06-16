import axios from "axios";

let apiHandler = axios.create({
    baseURL: import.meta.env.VITE_API_URL,
    headers: {
        Authorization: "Bearer " + localStorage.getItem('app_access')
    },
});

const initApiHandler = function () {
    apiHandler = axios.create({
        baseURL: import.meta.env.VITE_API_URL,
        headers: {
            Authorization: "Bearer " + localStorage.getItem("app_access"),
        },
    });
    addInterceptor();
};


function addInterceptor() {
    apiHandler.interceptors.response.use(

        (response) => {
            return response;
        },

        (error) => {
            if (error.response.status == 401) {
                localStorage.removeItem('app_access')
                window.location.href = '/'
                return
            }

            return Promise.reject(error);
        },

    );
}

export { apiHandler, initApiHandler };

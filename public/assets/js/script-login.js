const urlLogin = "http://127.0.0.1:8000/api/login";

let register = new Vue({
    el: "#login",
    data: {
        email: "",
        password: "",
    },
    methods: {
        async handleSubmit() {
            const data = {
                email: this.email,
                password: this.password,
            };

            const headers = {
                method: "POST",
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
            };

            const response = await axios
                .post(urlLogin, data, headers)
                .then((response) => response)
                .catch((error) => error.response);

            console.log(response.data.data);
            localStorage.setItem("token", response.data.data);
        },
    },
});

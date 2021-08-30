const urlRegister = "http://127.0.0.1:8000/api/register";
// const token = "24|gnqP91sPxVFIcIUhMa5BXdI6RGHC6mrW7ojrwkMX";

let register = new Vue({
    el: "#register",
    data: {
        name: "",
        username: "",
        email: "",
        password: "",
    },
    methods: {
        handleSubmit: function () {
            const data = {
                name: this.name,
                username: this.username,
                email: this.email,
                password: this.password,
            };

            const headers = {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
            };

            axios
                .post(urlRegister, data, headers)
                .then((response) => console.log(response.data))
                .catch((error) => console.log(error.response));
        },
    },
});

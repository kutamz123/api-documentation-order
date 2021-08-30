const urlOrders = "http://127.0.0.1:8000/api/orders";

let orders = new Vue({
    el: "#orders",
    data: {
        orders: [],
    },
    created: function () {
        const headers = {
            method: "GET",
            headers: {
                Authorization: "Bearer " + localStorage.getItem("token"),
                "Content-Type": "application/json",
                Accept: "application/json",
            },
        };
        axios
            .get(urlOrders, headers)
            .then((response) => {
                datas = response.data.data.data;
                this.orders = datas;
                console.log(datas);
            })
            .catch((error) => console.log(error.response));
    },
});

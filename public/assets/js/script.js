setInterval(function () {
    try {
        document.getElementById("button").click();
    } catch (error) {
        error;
        // location.reload();
    }
}, 3000);

const token = "40|ncp8eQjKXNd9e1sXDtQC9e8KvR95ubGFeBvRI7Ay";
const urlOrder = "http://127.0.0.1:8000/api/orders";
const urlExam = "http://127.0.0.1:8000/api/exams";

let appOrders = new Vue({
    el: "#orders",
    data: {
        orders: [],
        order: {},
    },
    created: function () {
        setInterval(() => {
            return this.getOrder();
        }, 5000);
    },
    methods: {
        getOrder() {
            return axios
                .get(urlOrder, {
                    method: "GET",
                    headers: {
                        Authorization: "Bearer " + token,
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                })
                .then((response) => {
                    datas = response.data.data.data;
                    this.orders = datas;
                })
                .catch((error) => console.log(error.response));
        },
        async handleSubmit(e) {
            this.order = e;
            await axios
                .post(urlExam, this.order, {
                    headers: {
                        Authorization: "Bearer " + token,
                    },
                })
                .then((response) => response + console.log("created"))
                .then((data) => data)
                .catch((error) => console.log(error.response.data.data));
            this.getOrder();
        },
    },
});

/**
 * javascript vanilla
 */

// function getOrder() {
//     axios
//         .get(urlOrder, {
//             method: "GET",
//             headers: {
//                 Authorization: "Bearer " + token,
//                 "Content-Type": "application/json",
//                 Accept: "application/json",
//             },
//         })
//         .then((response) => console.log(response))
//         .then((data) => console.log(data))
//         .catch((error) => console.log(error.response));
// }

// function postOrder() {
//     axios
//         .post(
//             urlOrder,
//             {
//                 uid: "1.2.40.0.13.1.770804.20200710.5252525",
//                 acc: "J203312323",
//                 patientid: "X10710",
//                 mrn: "343690",
//                 name: "ANDIKA UTAMA, TN.",
//                 address: "BANDUNG",
//                 sex: "M",
//                 birth_date: "19670523",
//                 weight: "null",
//                 name_dep: "IGD MALAM",
//                 xray_type_code: "CR",
//                 typename: "",
//                 prosedur: "Thorax",
//                 dokterid: "Y0026",
//                 named: "YOSUA NUGRAHA PRATAMA. dr",
//                 dokradid: "W0004",
//                 dokrad_name: "WAWAN KUSTIAWAN,dr.Sp.RAD",
//                 create_time: "20200628002845",
//                 schedule_date: "20200628",
//                 schedule_time: "00:58:45",
//                 priority: "Cito",
//                 pat_state: "Rawat Jalan",
//                 spc_needs: "",
//                 payment: "Tunai",
//                 fromorder: "simrs",
//             },
//             {
//                 headers: {
//                     Authorization: "Bearer " + token,
//                 },
//             }
//         )
//         .then((response) => console.log(response))
//         .then((data) => console.log(data))
//         .catch((error) => console.log(error));
// }
// getOrder();

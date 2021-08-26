const token = "24|gnqP91sPxVFIcIUhMa5BXdI6RGHC6mrW7ojrwkMX";
const urlOrder = "http://127.0.0.1:8000/api/orders";
const urlExam = "http://127.0.0.1:8000/api/exams";

var appOrders = new Vue({
    el: "#orders",
    data: {
        orders: [],
        form: {
            uid: "",
            acc: "",
            patientid: "",
            mrn: "",
            name: "",
            address: "",
            sex: "",
            birth_date: "",
            weight: "",
            name_dep: "",
            xray_type_code: "",
            typename: "",
            prosedur: "",
            dokterid: "",
            named: "",
            dokradid: "",
            dokrad_name: "",
            create_time: "",
            schedule_date: "",
            schedule_time: "",
            priority: "",
            pat_state: "",
            spc_needs: "",
            payment: "",
            fromorder: "",
        },
    },
    created: function () {
        axios
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

        setTimeout(
            () =>
                axios
                    .post(urlExam, this.form, {
                        method: "POST",
                        headers: {
                            Authorization: "Bearer " + token,
                        },
                    })
                    .then((response) => response)
                    .then((data) => data)
                    .catch((error) => console.log(error.config)),
            1000
        );
    },
    methods: {
        handleSubmit() {},
    },
});

function getOrder() {
    axios
        .get(urlOrder, {
            method: "GET",
            headers: {
                Authorization: "Bearer " + token,
                "Content-Type": "application/json",
                Accept: "application/json",
            },
        })
        .then((response) => console.log(response))
        .then((data) => console.log(data))
        .catch((error) => console.log(error.response));
}

function postOrder() {
    axios
        .post(
            urlOrder,
            {
                uid: "1.2.40.0.13.1.770804.20200710.5252525",
                acc: "J203312323",
                patientid: "X10710",
                mrn: "343690",
                name: "ANDIKA UTAMA, TN.",
                address: "BANDUNG",
                sex: "M",
                birth_date: "19670523",
                weight: "null",
                name_dep: "IGD MALAM",
                xray_type_code: "CR",
                typename: "",
                prosedur: "Thorax",
                dokterid: "Y0026",
                named: "YOSUA NUGRAHA PRATAMA. dr",
                dokradid: "W0004",
                dokrad_name: "WAWAN KUSTIAWAN,dr.Sp.RAD",
                create_time: "20200628002845",
                schedule_date: "20200628",
                schedule_time: "00:58:45",
                priority: "Cito",
                pat_state: "Rawat Jalan",
                spc_needs: "",
                payment: "Tunai",
                fromorder: "simrs",
            },
            {
                headers: {
                    Authorization: "Bearer " + token,
                },
            }
        )
        .then((response) => console.log(response))
        .then((data) => console.log(data))
        .catch((error) => console.log(error));
}
// getOrder();

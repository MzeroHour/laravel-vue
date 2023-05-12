import "./bootstrap";
import "../../node_modules/bootstrap/dist/css/bootstrap.min.css";
import { createApp } from "vue/dist/vue.esm-bundler.js";

const app = createApp({});

import ExampleComponent from "./components/ExampleComponent.vue";
import ProductsComponent from "./components/ProductsComponent.vue";

import Form from "vform";

import { Bootstrap5Pagination } from "laravel-vue-pagination";
import { Button, HasError, AlertError } from "vform/src/components/bootstrap5";
import Swal from "sweetalert2";
import "sweetalert2/src/sweetalert2.scss";
// import VueProgressBar from "vue-progressbar";
import VueProgressBar from "@aacassandra/vue3-progressbar";

import { LoadingPlugin } from "vue-loading-overlay";
import "vue-loading-overlay/dist/css/index.css";

app.component(AlertError.name, AlertError);

app.component("example-component", ExampleComponent);
app.component("products-component", ProductsComponent);
app.component("pagination", Bootstrap5Pagination);

const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
});
const options = {
    color: "#78faea",
    failedColor: "#874b4b",
    thickness: "5px",
    transition: {
        speed: "0.2s",
        opacity: "0.6s",
        termination: 300,
    },
    autoRevert: true,
    location: "top",
    inverse: false,
};

window.Form = Form;
window.Swal = Swal;
window.Toast = Toast;

app.use(LoadingPlugin, {
    color: "#3d76d1",
    width: "80px",
    height: "80px",
});
app.use(VueProgressBar, options).mount("#app");

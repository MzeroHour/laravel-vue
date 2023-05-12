<template>
    <div class="container my-5">
        <!-- Create -->
        <div class="row justify-content-end mb-3">
            <div class="col-4">
                <button class="btn btn-primary" @click="create">
                    <i class="fas fa-plus-circle me-1"></i>
                    Create
                </button>
            </div>
            <div class="col-4">
                <form @submit.prevent="view">
                    <div class="input-group">
                        <input
                            v-model="search"
                            type="text"
                            placeholder="Search.."
                            class="form-control"
                        />
                        <div class="input-group-append">
                            <button class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Create End -->

        <!-- Table -->
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-header">
                            {{ isEditMod ? "Edit" : "Create" }}
                        </h4>
                        <AlertError :form="product" :message="message" />
                        <form
                            @submit.prevent="isEditMod ? update() : store()"
                            @keydown="product.onKeydown($event)"
                        >
                            <div class="form-group mt-3">
                                <label class="control-label" for="name"
                                    >Name:
                                </label>
                                <input
                                    v-model="product.name"
                                    type="text"
                                    class="form-control"
                                />
                                <div
                                    class="text-danger"
                                    v-if="product.errors.has('name')"
                                    v-html="product.errors.get('name')"
                                />
                            </div>
                            <div class="form-group mt-3">
                                <label for="name">Price: </label>
                                <input
                                    v-model="product.price"
                                    type="number"
                                    class="form-control"
                                />
                                <div
                                    class="text-danger"
                                    v-if="product.errors.has('price')"
                                    v-html="product.errors.get('price')"
                                />
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">
                                <i class="fas fa-save me-1"></i> Save
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in products.data" :key="product.id">
                            <td>{{ product.id }}</td>
                            <td>{{ product.name }}</td>
                            <td>{{ product.price }}</td>
                            <td>
                                <button
                                    class="btn btn-success btn-sm me-2"
                                    @click="edit(product)"
                                >
                                    <i class="fas fa-edit me-1"></i> Edit
                                </button>
                                <button
                                    class="btn btn-danger btn-sm"
                                    @click="destroy(product.id)"
                                >
                                    <i class="fas fa-trash-alt me-1"></i> Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- End Table -->

        <pagination
            align="center"
            :data="products"
            @pagination-change-page="view"
        >
        </pagination>
    </div>
</template>

<script>
export default {
    name: "ProductsComponent",
    data() {
        return {
            search: "",
            isEditMod: false,
            products: {},
            product: new Form({
                id: "",
                name: "",
                price: "",
            }),
            message: "",
        };
    },

    methods: {
        // searchProduct() {
        //     axios.get("/api/product?search=" + this.search).then((response) => {
        //         this.products = response.data;
        //     });
        // },
        view(page = 1) {
            this.$Progress.start();

            // Overlay Loading
            let loader = this.$loading.show({});

            this.product
                .get(`/api/product?page=${page}&search=${this.search}`)
                .then((response) => {
                    this.products = response.data;
                    this.$Progress.finish();
                    loader.hide();
                })
                .catch((error) => {
                    console.log(error);
                    this.$Progress.fail();
                    loader.hide();
                });
        },
        create() {
            this.product.clear();
            this.isEditMod = false;

            this.product.reset();
            // this.product.id = "";
            // this.product.name = "";
            // this.product.price = "";
        },
        store() {
            this.product
                .post("/api/product")
                .then((response) => {
                    this.view();
                    this.product.reset();
                    // this.product.id = "";
                    // this.product.name = "";
                    // this.product.price = "";
                    Toast.fire({
                        icon: "success",
                        title: "Created  successfully",
                    });
                })
                .catch((error) => {
                    this.message = error.response.data.message;
                });
        },
        edit(product) {
            this.product.clear();
            this.isEditMod = true;

            this.product.fill(product);
            // this.product.id = product.id;
            // this.product.name = product.name;
            // this.product.price = product.price;
        },
        update() {
            this.product
                .put(`/api/product/${this.product.id}`)
                .then((response) => {
                    this.view();
                    this.product.reset();
                    // this.product.id = "";
                    // this.product.name = "";
                    // this.product.price = "";

                    Toast.fire({
                        icon: "success",
                        title: "Updated  successfully",
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        destroy(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.product
                        .delete(`/api/product/${id}`)
                        .then((response) => {
                            this.view();
                            Swal.fire({
                                title: "Deleted",
                                icon: "success",
                            });
                            Toast.fire({
                                icon: "success",
                                title: "Deleted  successfully",
                            });
                        });
                }
            });
            // if (!confirm("Are You Sure to delete")) {
            //     return;
            // }
            // this.product.delete(`/api/product/${id}`).then((response) => {
            //     this.view();
            // });
        },
    },
    created() {
        this.view();
    },
};
</script>

<style></style>

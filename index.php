<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

    <title>Gerenciador de gatos</title>

    <!-- Required Stylesheets -->
    <link
            type="text/css"
            rel="stylesheet"
            href="https://unpkg.com/bootstrap/dist/css/bootstrap.min.css"
    />
    <link
            type="text/css"
            rel="stylesheet"
            href="https://unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.css"
    />

    <!-- Load polyfills to support older browsers -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es2015%2CIntersectionObserver"></script>

    <!-- Required scripts -->
    <script src="https://unpkg.com/vue@latest/dist/vue.js"></script>
    <script src="https://unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.js"></script>

</head>
<body>
<div id='vueapp'>
<template>
    <div>
        <b-container class="bv-example-row">
            <h1>Gatos Famosos? </h1>
            <div>
                <b-table
                        show-empty
                        small
                        stacked="md"
                        :fields="fields"
                        :items="contacts">
                    <template v-slot:cell(actions)="row">
                        <b-button  size="sm" @click="info(row.item,  $event.target)" class="mr-1">
                           Editar
                        </b-button>
                        <b-button size="sm" variant="danger" @click="deletar(row.item.id)" class="mr-1">
                           Excluir
                        </b-button>
                    </template>
                </b-table>
            </div>
            <b-modal ref="modal" hide-footer :id="infoModal.id" :title="infoModal.title">
                <form ref="form">
                    <b-alert dismissible variant="success" v-if="alert === 1"show>Gato atualizado com sucesso!</b-alert>
                    <b-form-group
                            label="Nome"
                            label-for="name"
                            invalid-feedback="Name is required"
                    >
                        <b-form-input
                                id="name"
                                v-model="infoModal.name"
                                name="editName"
                                required
                        ></b-form-input>
                        <b-form-group
                                label="Cor"
                                label-for="color"
                                invalid-feedback="Color is required"
                        >
                            <b-form-input
                                    id="color"
                                    name="editColor"
                                    v-model="infoModal.color"
                                    required
                            >
                            </b-form-input>
                        <b-button class="mt-3" variant="outline-success" block @click="editCats(infoModal.id,  $event.target)">Atualizar</b-button>
                    </b-form-group>
                </form>
            </b-modal>
        </b-container>
        <b-container class="bv-example-row">
            <b-alert dismissible variant="success" v-if="alert === 2"show>Gato adicionado com sucesso!</b-alert>
            <b-row>
                <b-col>
                    <form ref="create_form">
                    <b-form-group
                            id="input-group-1"
                            label="Nome:"
                            label-for="input-1"
                    >
                        <b-form-input
                                id="create_name"
                                v-model="create_name"
                                type="text"
                                required
                        >
                        </b-form-input>
                    </b-form-group>
                    <b-form-group id="input-group-2" label="Cores:" label-for="input-2">
                        <b-form-input
                                id="create_color"
                                v-model="create_color"
                                required
                        ></b-form-input>
                        <b-button class="mt-3" variant="outline-success" block @click="createCats($event.target)">Adicionar</b-button>
                    </b-form-group>
                    </form>
                </b-col>
            </b-row>
        </b-container>
    </div>
</template>

</div>
<script type="text/javascript" src="js/index.js"></script>
</body>
</html>
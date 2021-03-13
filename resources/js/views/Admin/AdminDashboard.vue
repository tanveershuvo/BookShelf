<template>
    <v-data-table
        :headers="headers"
        :items="authors"
        sort-by="name"
        class="elevation-1"
    >
        <template v-slot:top>
            <v-toolbar
                flat
            >
                <v-toolbar-title>Author CRUD</v-toolbar-title>
                <v-divider
                    class="mx-4"
                    inset
                    vertical
                ></v-divider>
                <v-spacer></v-spacer>
                <v-dialog
                    v-model="dialog"
                    max-width="500px"
                >
                    <template v-slot:activator="{ on }">
                        <v-btn
                            color="primary"
                            dark
                            class="mb-2"
                            v-on="on"
                        >
                            Add New Author
                        </v-btn>
                    </template>
                    <ValidationObserver ref="observer" v-slot="{ validate, handleSubmit }">
                        <v-form @submit.prevent="handleSubmit(save)">
                    <v-card>

                        <v-card-title>
                            <span class="headline">{{ formTitle }}</span>
                        </v-card-title>

                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col
                                        cols="12"
                                    >
                                        <ValidationProvider v-slot="{ errors }" name="name" rules="required">
                                        <v-text-field
                                            v-model="editedItem.name"
                                            label="Author name"
                                            :error-messages="errors"
                                        ></v-text-field>
                                        </ValidationProvider>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                    >
                                        <ValidationProvider v-slot="{ errors }" name="email" rules="required|email">
                                        <v-text-field
                                            v-model="editedItem.email"
                                            label="Email"
                                            :error-messages="errors"
                                        ></v-text-field>
                                        </ValidationProvider>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                color="blue darken-1"
                                text
                                @click="close"
                            >
                                Cancel
                            </v-btn>
                            <v-btn
                                color="blue darken-1"
                                text
                                type="submit"
                            >
                                Save
                            </v-btn>
                        </v-card-actions>

                    </v-card>
                        </v-form>
                    </ValidationObserver>
                </v-dialog>
                <v-dialog v-model="dialogDelete" max-width="500px">
                    <v-card>
                        <v-card-title class="headline">Are you sure you want to delete this item?</v-card-title>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                            <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
                            <v-spacer></v-spacer>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-toolbar>
        </template>
            <template v-slot:item.actions="{ item }">
            <v-icon
                small
                color="primary"
                class="mr-2"
                @click="editItem(item)"
            >
                mdi-pencil
            </v-icon>
            <v-icon
                small
                color="red"
                @click="deleteItem(item)"
            >
                mdi-delete
            </v-icon>
        </template>
    </v-data-table>
</template>

<script>
import {required, email} from 'vee-validate/dist/rules'
import { extend, ValidationObserver, ValidationProvider, setInteractionMode } from 'vee-validate'
import {mapGetters,mapActions} from 'vuex'
setInteractionMode("eager");

extend("required", {
    ...required,
    message: "{_field_} can not be empty",
});
extend("email", {
    ...email,
    message: "Email must be valid",
});

export default {
    components: {
        ValidationProvider,
        ValidationObserver,
    },
    data: () => ({
        dialog: false,
        dialogDelete: false,
        headers: [
            {
                text: 'Name',
                align: 'start',
                value: 'name',
            },
            { text: 'Email', value: 'email' },
            { text: 'Actions', value: 'actions', sortable: false },
        ],
        isEdit: 0,
        editedItem: {
            name: '',
            email:''
        },
        defaultItem: {
            name: '',
            email: '',
        },
    }),

    computed: {
        ...mapGetters({
            authors: 'GET_ALL_AUTHORS',
        }),

        formTitle () {
            return this.isEdit === 0 ? 'New Author' : 'Edit Author'
        },
    },

    watch: {
        dialog (val) {
            val || this.close()
        },
        dialogDelete (val) {
            val || this.closeDelete()
        },
    },
    methods: {

        editItem (item) {
            this.isEdit = 1
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem (item) {
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        close () {
            this.dialog = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.isEdit = 0
            })
            this.errors.clear();

        },

        closeDelete () {
            this.dialogDelete = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.isEdit = 0
            })
        },
        save(){
            if (this.isEdit === 0) {
                this.$store.dispatch("ADD_AUTHOR", this.editedItem).then(success => {
                    this.close()
                })
            }else{
                this.$store.dispatch("UPDATE_AUTHOR",this.editedItem).then(success => {
                    this.close()
                })
            }
        },
        deleteItemConfirm () {
            this.$store.dispatch("DELETE_AUTHOR", this.editedItem.id).then(success => {
                this.close()
            })
            this.closeDelete()
        },
    },
    mounted(){
        this.ALL_AUTHORS
    }
}
</script>

<!--<script>-->
<!--import {mapGetters,mapActions} from 'vuex'-->




<!--export default {-->
<!--    data () {-->
<!--        return {-->
<!--            search: '',-->
<!--            headers: [-->
<!--                {-->
<!--                    text: 'No.',-->
<!--                    align: 'start',-->
<!--                    filterable: false,-->
<!--                    value: 'id',-->
<!--                },-->
<!--                { text: 'Authors', value: 'name' },-->
<!--                { text: 'E-mail', value: 'email' },-->
<!--                { text: 'Action', value: 'action' },-->
<!--            ],-->
<!--        }-->
<!--    },-->
<!--    methods:{-->
<!--        ...mapActions(['ALL_AUTHORS']),-->
<!--    },-->
    computed:{
    ...mapGetters({
            authors: 'GET_ALL_AUTHORS',
        }),
    },
    mounted(){
        this.ALL_AUTHORS
    }
<!--}-->
<!--</script>-->

<style scoped>

</style>

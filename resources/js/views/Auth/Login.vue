<template>
    <v-container class="grey lighten-5" fluid>
        <v-card
            class="mx-auto mt-15"
            elevation="12"
            height="auto"
            max-width="600"
        >
            <v-progress-linear
                color="lime"
                indeterminate
            ></v-progress-linear>
            <ValidationObserver ref="observer" v-slot="{ validate, handleSubmit }">
                <v-form @submit.prevent="handleSubmit(login)">
                    <h1 class="pt-4 text-center">Log In Form</h1>
                    <v-row class="px-4">
                        <v-col cols="12">
                            <v-snackbar
                                v-model="snackbar.showing"
                                :bottom="true"
                                :right="true"
                                :color="snackbar.color"
                            >
                                {{ snackbar.text }}
                                <template v-slot:action="{ attrs }">
                                    <v-btn
                                        dark
                                        text
                                        v-bind="attrs"
                                        @click="close"
                                    >
                                        Close
                                    </v-btn>
                                </template>
                            </v-snackbar>
                            <ValidationProvider v-slot="{ errors }" name="email" rules="required|email">
                                <v-text-field
                                    v-model="form.email"
                                    :error-messages="errors"
                                    label="E-mail"
                                    outlined
                                    hide-details
                                ></v-text-field>
                                <span class="red--text" >{{ errors[0] }}</span>
                            </ValidationProvider>
                        </v-col>
                        <v-col cols="12">
                            <ValidationProvider v-slot="{ errors }" name="password" rules="required|min:6">
                                <v-text-field
                                    v-model="form.password"
                                    :error-messages="errors"
                                    :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
                                    :type="show ? 'text' : 'password'"
                                    label="Password"
                                    outlined
                                    hide-details
                                    @click:append="show = !show"
                                ></v-text-field>
                                <span class="red--text">{{ errors[0] }}</span>
                            </ValidationProvider>
                        </v-col>
                        <v-col cols="12" class="text-center">
                            <v-btn color="success" type="submit" class="py-5">Log in</v-btn>
                        </v-col>
                        <v-col cols="12" class="text-center">
                            <v-btn link icon @click="registerPage">
                                Not Registered Yet?
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-form>
            </ValidationObserver>
        </v-card>
    </v-container>
</template>


<script>
import { required, email, min } from 'vee-validate/dist/rules'
import { extend, ValidationObserver, ValidationProvider, setInteractionMode } from 'vee-validate'
import {mapGetters} from "vuex";
import user from "../../stores/modules/user";

setInteractionMode("eager");

extend("required", {
    ...required,
    message: "{_field_} can not be empty",
});

extend("min", {
    ...min,
    message: "{_field_} must not be less than {length} characters",
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
        show: false,
        form: {
            email: null,
            password: null,
        },
        error: '',
        success: '',
    }),
    computed: {
        ...mapGetters({
            snackbar:'GET_SNACKBAR'
        }),
    },
    methods: {
         login() {
             this.loader = true;
                this.$store.dispatch("LOGIN", this.form)
                .then(success => {
                })
                .catch(error => {
                    this.error = error;
                    this.loader = false;
                })
        },
        registerPage(){
            this.$router.push({name:'Registration'})
        },
        close(){
            this.$store.dispatch("RESET_SNACKBAR")
        }
    },
};
</script>


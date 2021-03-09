<template>

    <v-container class="grey lighten-5" fluid>
        <v-card
            class="mx-auto mt-5 mb-15"
            elevation="12"
            height="auto"
            max-width="600"
        >
            <v-progress-linear
                color="primary"
                indeterminate
            ></v-progress-linear>
            <ValidationObserver ref="observer" v-slot="{ validate, handleSubmit }">
                <v-form @submit.prevent="handleSubmit(Register)">
                    <h1 class="pt-4 text-center">Sign Up Form</h1>
                    <v-row class="px-4 justify-center">
                        <v-col cols="12">
                            <div v-if="errorMessage">
                                <v-alert type="error">
                                    {{errorMessage}}
                                </v-alert>
                            </div>
                        </v-col>
                        <v-col cols="12">
                            <ValidationProvider v-slot="{ errors }" name="name" rules="required">
                                <v-text-field
                                    v-model="form.name"
                                    :error-messages="errors"
                                    label="Name"
                                    required
                                    outlined
                                    hide-details
                                ></v-text-field>
                                <span class="red--text">{{ errors[0] }}</span>
                            </ValidationProvider>
                        </v-col>
                        <v-col cols="12">
                            <ValidationProvider v-slot="{ errors }" name="email" rules="required|email">
                                <v-text-field
                                    v-model="form.email"
                                    :error-messages="errors"
                                    label="E-mail"
                                    required
                                    outlined
                                    hide-details
                                ></v-text-field>
                                <span class="red--text">{{ errors[0] }}</span>

                            </ValidationProvider>
                        </v-col>
                        <v-col cols="12">
                            <ValidationProvider v-slot="{ errors }" name="password" rules="required||password:@confirm|min:6">
                                <v-text-field
                                    v-model="form.password"
                                    :error-messages="errors"
                                    :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                    :type="show1 ? 'text' : 'password'"
                                    label="Password"
                                    required
                                    outlined
                                    hide-details
                                    @click:append="show1 = !show1"
                                ></v-text-field>
                                <span class="red--text">{{ errors[0] }}</span>
                            </ValidationProvider>
                        </v-col>
                        <v-col cols="12" >
                            <ValidationProvider v-slot="{ errors }" name="confirm" rules="required">
                                <v-text-field
                                    v-model="form.password_confirmation"
                                    :error-messages="errors"
                                    :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
                                    :type="show2 ? 'text' : 'password'"
                                    label="Confirm Password"
                                    required
                                    outlined
                                    hide-details
                                    @click:append="show2 = !show2"
                                ></v-text-field>
                                <span class="red--text">{{ errors[0] }}</span>
                            </ValidationProvider>
                        </v-col>
                        <v-col cols="12" class="text-center">
                            <v-btn color="primary" class="py-6" type="submit">Sign up</v-btn>
                        </v-col>
                        <v-col cols="12" class="text-center">
                            <v-btn link icon @click="loginPage">
                                Have an account already?
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


setInteractionMode('eager')

extend('password', {
    params: ['target'],
    validate(value, { target }) {
        return value === target;
    },
    message: 'Password confirmation does not match'
});
extend('required', {
    ...required,
    message: '{_field_} can not be empty',
})

extend('min', {
    ...min,
    message: '{_field_} may not be less than {length} characters',
})

extend('email', {
    ...email,
    message: 'Email must be valid',
})

export default {
    components: {
        ValidationProvider,
        ValidationObserver,
    },
    data: () => ({
        form:{
            email: '',
            name: '',
            password: '',
            password_confirmation: '',
        },
        errorMessage: null,
        show1: false,
        show2: false,
    }),
    methods: {
        Register() {
            this.loader = true;
            this.$store.dispatch("REGISTER", this.form)
                .then(success => {
                    this.$router.push("/")
                })
                .catch(error => {
                    this.error = error;
                    this.loader = false;
                })
        },
        loginPage(){
            this.$router.push({name:'Login'})
        }
    },
}
</script>

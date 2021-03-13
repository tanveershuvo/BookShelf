export default {
    state: {
        snackbar: {showing:false,text:'',color:''},
    },
    mutations:{
        SET_SNACKBAR:(state, payload)=>{
            state.snackbar.text = payload.msg
            state.snackbar.color = payload.type
            state.snackbar.showing = true
        },
        SET_NULL_SNACKBAR:(state,)=>{
            state.snackbar.text = ''
            state.snackbar.color = ''
            state.snackbar.showing = false
        },
    },
    getters:{
        GET_SNACKBAR: state => {
            return state.snackbar;
        },
    },
    actions:{
        SNACKBAR:({commit},payload)=>{
            console.log(payload)
            commit('SET_SNACKBAR',payload)
            setTimeout(() => commit('SET_NULL_SNACKBAR'), 5000)
        },
        RESET_SNACKBAR:({commit})=>{
            commit('SET_NULL_SNACKBAR')
        }
    }
}

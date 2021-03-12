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
    },
    getters:{
        GET_SNACKBAR: state => {
            return state.snackbar;
        },
    },
    actions:{
        SNACKBAR:({commit},payload)=>{
            //console.log(payload)
            commit('SET_SNACKBAR',payload)
        }
    }
}

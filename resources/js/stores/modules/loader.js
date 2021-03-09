export default {
    state: {
        isLoading: true,
    },
    mutations:{
        SET_LOADING:(state, payload)=>{
            state.isLoading = payload;
        },
    },
    getters:{
        GET_LOADING: state => {
            return state.isLoading;
        },
    },
    actions:{
        LOADING:({commit},payload)=>{
            //console.log(payload)
            commit('SET_LOADING',payload)
        }
    }
}

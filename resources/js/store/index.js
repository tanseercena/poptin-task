export default {

    state: {
        addRule: false,
        rules: [],
    },

    getters: {
        getAddRule(state){
            return state.addRule
        },
        getAllRules(state){
            return state.rules
        }
    },

    actions: {
        fetchAllRules(context){

            axios.get("api/rules")

                .then((response)=>{
                    console.log(response.data)
                    context.commit("rules",response.data) //categories will be run from mutation

                })

                .catch(()=>{

                    console.log("Error........")

                })
        },
        toggleRuleForm(context) {
            context.commit("toggleRule");
        },
        saveRule(context, rule) {

            axios.post("api/rules",rule)
                .then((response)=>{
                    console.log(response.data.rules)
                    context.commit("rules",response.data.rules) //categories will be run from mutation

                })

                .catch(()=>{

                    console.log("Error........")

                })
        },
        deleteRule(context, rule) {

            axios.delete("api/rules/"+rule.id)
                .then((response)=>{
                    console.log(response.data.rules)
                    context.commit("rules",response.data.rules) //categories will be run from mutation

                })

                .catch(()=>{

                    console.log("Error........")

                })
        },
    },

    mutations: {
        rules(state,data) {
            return state.rules = data
        },
        toggleRule(state,data) {
            return state.addRule = !state.addRule
        },
    }
}

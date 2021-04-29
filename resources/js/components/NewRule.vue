<template>
    <div>
        <button
            @click="toggleRuleForm"
            type="button"
            class="focus:outline-none text-white text-sm py-2.5 px-5 rounded-md bg-indigo-500 hover:indigo-blue-600 hover:shadow-lg">
            Add New Rule
        </button>
        <div v-if="add_rule">
            <div class="flex h-100 w-full items-center justify-center bg-teal-lightest font-sans">
                <div class="bg-white rounded shadow p-6 m-4 w-full ">

                    <div class="mb-4">
                        <h1 class="text-grey-900">Add New Rule</h1>

                        <div class="flex mt-4 items-center" v-for="(condition,r) in rule.conditions" :key="r">
                            <select v-model="condition.show" class="shadow appearance-none border rounded w-full py-2 px-3 mr-4 text-grey-darker">
                                <option value="1">Show On</option>
                                <option value="0">Don't show on</option>
                            </select>
                            <select v-model="condition.rule" class="shadow appearance-none border rounded w-full py-2 px-3 mr-4 text-grey-darker">
                                <option disabled>Select Rule</option>
                                <option value="contains">contains</option>
                                <option value="start">start with</option>
                                <option value="ends">ends with</option>
                                <option value="exact">exact dropdown</option>
                            </select>
                            <p class="text-gray-900  px-3 mr-2 font-bold">www.youdomain.com/</p>
                            <input v-model="condition.rule_txt" class="shadow appearance-none border rounded w-80 py-2 px-3 mr-4 text-grey-darker" >
                            <button
                                @click="removeRule(r)"
                                class="inline-block p-2 text-center text-white transition bg-red-500 rounded-lg shadow ripple hover:shadow-lg hover:bg-red-600 focus:outline-none"
                            >
                                <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        fill-rule="evenodd"
                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </button>
                        </div>

                        <button
                            @click="addRule"
                            class="mt-4 inline-block px-6 py-2 text-xs font-medium leading-6 text-center text-white uppercase transition bg-red-500 rounded shadow ripple hover:shadow-lg hover:bg-red-600 focus:outline-none"
                        >
                            Add Rule
                        </button>

                    </div>

                    <div class="flex flex-wrap mb-6">
                        <div class="relative w-full appearance-none label-floating">
                        <textarea
                            v-model="rule.alert_text"
                            class="autoexpand tracking-wide py-2 px-4 mb-3 leading-relaxed appearance-none block w-full bg-gray-200 border border-gray-200 rounded focus:outline-none focus:bg-white focus:border-gray-500"
                            placeholder="Alert text..."></textarea>
                        <label for="message" class="absolute tracking-wide py-2 px-4 mb-4 opacity-0 leading-tight block top-0 left-0 cursor-text">Message...
                        </label>
                        </div>
                    </div>

                    <button
                        @click="saveRule"
                        class="inline-block px-6 py-2 text-xs font-medium leading-6 text-center text-white uppercase transition bg-green-500 rounded shadow ripple hover:shadow-lg hover:bg-green-600 focus:outline-none"
                    >
                        Save
                    </button>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "NewRule",
        data() {
            return {
                rule: {
                    conditions: [{show: 1, rule: '', rule_txt: ''}],
                    alert_text: ''
                }
            }
        },
        methods: {
            toggleRuleForm: function() {
                this.$store.dispatch('toggleRuleForm')
            },
            addRule: function() {
                this.rule.conditions.push({show: 1, rule: '', rule_txt: ''});
            },
            removeRule: function(index) {
                this.rule.conditions.splice(index, 1);
            },
            saveRule: function() {
                this.$store.dispatch('saveRule', this.rule)
                this.rule = {
                    conditions: [{show: 1, rule: '', rule_txt: ''}],
                    alert_text: ''
                }
            }
        },
        computed: {
            add_rule() {
                return this.$store.getters.getAddRule
            }
        }
    }
</script>

<style scoped>

</style>

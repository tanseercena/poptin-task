<template>
    <div>
        <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
            <table class="min-w-full leading-normal">
                <thead>
                <tr>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Alert Text
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Rules
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        JS Embed Code
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Created at
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(rule,r) in rules" :key="r">
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <div class="flex items-center">
                            <p class="text-gray-900 whitespace-no-wrap">
                                {{ rule.alert_text }}
                            </p>
                        </div>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 whitespace-no-wrap border-b" v-for="(condition,c) in rule.conditions" :key="c">
                            {{ condition.show == 1 ? 'Show On' : 'Don\'t show on' }} ->
                            {{ condition.rule }} ->
                            {{ condition.rule_txt }}
                        </p>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <div class="w-60 text-gray-900 whitespace-no-wrap select-all border border-indigo-200 p-1" @click="copyCode">
                            <pre v-html="rule.script"><code v-pre></code></pre>
                        </div>
                        <p class="text-xs">Click above code to copy it!</p>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">
                            {{ rule.created_at | formatDate }}
                        </p>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <button
                            @click="deleteRule(rule)"
                            class="inline-block px-6 py-2 text-xs font-medium leading-6 text-center text-red-500 uppercase transition bg-transparent border-2 border-red-500 rounded ripple hover:bg-red-100 focus:outline-none"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>

        </div>
    </div>
</template>

<script>
    export default {
        name: "RulesList",
        mounted() {
            this.$store.dispatch("fetchAllRules")
        },
        methods: {
            deleteRule: function(rule) {
                this.$store.dispatch('deleteRule', rule)
            },
            copyCode: function() {
                document.execCommand("copy");
            }
        },
        computed: {
            rules() {
                return this.$store.getters.getAllRules
            },
            app_url() {
                return process.env.MIX_APP_URL
            }
        }
    }
</script>

<style scoped>

</style>

import { apiHandler } from '@/plugins/api-handler'

const tabuSearchUrl = 'tabu-search'

const tabuSearch = {
  namespaced: true,
  actions: {
    fetchTabuSearch(_context, parameter) {
      return new Promise((resolve, reject) => {
        const tabuSize = parameter?.tabuSize || 100
        const maxIteration =
          typeof parameter?.maxIteration === 'undefined'
            ? 5
            : parameter.maxIteration
        const path = `${tabuSearchUrl}?tabu_size=${tabuSize}&max_iteration=${maxIteration}${parameter.uuid ? `&uuid=${parameter.uuid}` : ''}` // prettier-ignore
        apiHandler
          .get(path, {
            params: parameter,
          })
          .then((response) => {
            resolve(response)
          })
          .catch((errors) => {
            reject(errors)
          })
      })
    },
  },
}

export default tabuSearch

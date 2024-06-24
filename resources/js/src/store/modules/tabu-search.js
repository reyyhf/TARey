import { apiHandler } from '@/plugins/api-handler'

const tabuSearchUrl = 'tabu-search'

const tabuSearch = {
  namespaced: true,
  actions: {
    fetchTabuSearch(_context, parameter) {
      return new Promise((resolve, reject) => {
        const tabuSize = parameter?.tabuSize || 10
        const maxIteration = parameter?.maxIteration || 1000
        const path = `${tabuSearchUrl}?tabu_size=${tabuSize}&max_iteration=${maxIteration}`
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

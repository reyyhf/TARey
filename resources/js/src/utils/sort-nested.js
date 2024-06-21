export function sortNested(data, criteria) {
  return data.sort((a, b) => {
    for (let criterion of criteria) {
      const direction = criterion[0]
      const keys = criterion.slice(1).split('.')

      const valA = keys.reduce(
        (obj, key) => (obj && obj[key] !== undefined ? obj[key] : undefined),
        a
      )
      const valB = keys.reduce(
        (obj, key) => (obj && obj[key] !== undefined ? obj[key] : undefined),
        b
      )

      if (valA < valB) {
        return direction === '<' ? -1 : 1
      } else if (valA > valB) {
        return direction === '<' ? 1 : -1
      }
    }
    return 0
  })
}

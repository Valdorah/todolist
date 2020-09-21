import './app'
import '../css/todo.sass'

const deleteBtn = document.getElementById('delete-todo')
const deleteError = document.getElementById('delete-error')
const spinner = document.getElementById('spinner')

deleteBtn.addEventListener('click', (e) => {
  e.preventDefault()

  spinner.style.display = 'inline'

  const id = e.target.dataset.id
  fetch(`/todo/delete/${id}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
    .then((res) => {
      if(res.status >= 400){
        throw new Error('Bad request')
      }
      spinner.style.display = 'none'
      window.location = '/'
    })
    .catch(() => {
      spinner.style.display = 'none'
      deleteError.style.display = 'block'
    })
});
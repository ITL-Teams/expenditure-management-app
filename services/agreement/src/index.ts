import { application } from './infraestructure/server/app'

application.listen(application.get('port'), () => {
  console.log(
    `${application.get('app_name')} server runnig on port ${application.get(
      'port'
    )}`
  )
})

import { Router } from 'express'
import { AgreementDeleterController } from '../controller/AgreementDeleter/AgreementDeleterController'
import { MySqlAgreementRepository } from '../database/MySqlAgreementRepository'
export const router = Router()

const agreement_repository = new MySqlAgreementRepository()

router.delete('/agreement/delete/:agreementId', async (request, response) => {
  const controller = new AgreementDeleterController(agreement_repository)
  const controllerResponse = await controller.handler({
    agreementId: request.params.agreementId
  })

  response.json(controllerResponse)
})

router.all('*', (request, response) => {
  response.status(404).send()
})

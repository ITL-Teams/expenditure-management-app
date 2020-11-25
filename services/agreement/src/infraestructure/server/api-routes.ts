import { Router } from 'express'
import { AgreementCreatorController } from '../controller/AgreementCreator/AgreementCreatorController'
import { AgreementDeleterController } from '../controller/AgreementDeleter/AgreementDeleterController'
import { MySqlAgreementRepository } from '../database/MySqlAgreementRepository'
export const router = Router()

const agreement_repository = new MySqlAgreementRepository()

router.post('/create', async (request, response) => {
  const controller = new AgreementCreatorController(agreement_repository)
  const controllerResponse = await controller.handler({
    agreement_id: request.body.agreement_id,
    account_id: request.body.account_id,
    budget_id: request.body.budget_id,
    client_name: request.body.client_name,
    agreement_message: request.body.agreement_message
  })

  response.json(controllerResponse)
})

router.delete('/delete/:agreementId', async (request, response) => {
  const controller = new AgreementDeleterController(agreement_repository)
  const controllerResponse = await controller.handler({
    agreementId: request.params.agreementId
  })

  response.json(controllerResponse)
})

router.all('*', (request, response) => {
  response.status(404).send()
})

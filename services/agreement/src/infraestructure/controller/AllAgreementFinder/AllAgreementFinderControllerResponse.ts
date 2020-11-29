export type AgreementRepose = {
  agreementId: string
  agreementMessage: string
  agreementSignature: string
  accountId: string
  budgetId: string
  clientName: string
}

export type AllAgreementFinderControllerResponse = {
  success?: {
    account_id: string
    agreements: AgreementRepose[]
  }
  error?: {
    message: string
    reason: string
  }
}

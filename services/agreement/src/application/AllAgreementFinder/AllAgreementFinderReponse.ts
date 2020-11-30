export type AgreementRepose = {
  agreementId: string
  agreementMessage: string
  agreementSignature: string
  accountId: string
  budgetId: string
  clientName: string
}

export type AllAgreementFinderReponse = {
  accountId: string
  agreements: AgreementRepose[]
}

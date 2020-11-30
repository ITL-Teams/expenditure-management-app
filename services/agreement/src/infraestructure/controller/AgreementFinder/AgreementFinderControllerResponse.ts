export type AgreementFinderControllerResponse = {
  success?: {
    agreement_id: string
    agreement_message: string
    agreement_signature: string
    account_id: string
    budget_id: string
    client_name: string
  }
  error?: {
    message: string
    reason: string
  }
}

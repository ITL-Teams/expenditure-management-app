export type AgreementCreatorResponse = {
  success?: {
    agreement_id: string
    agreement_message: string
    agreement_signature: string
  }
  error?: {
    message: string
    reason: string
  }
}

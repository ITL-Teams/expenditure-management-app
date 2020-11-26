export class AgreementNotFoundError extends Error {
  constructor(message: string) {
    super(message)
    this.name = 'AgreementNotFoundError'
  }
}

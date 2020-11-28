export class AccountIdNotExists extends Error {
  constructor(message: string) {
    super(message)
    this.name = 'AccountIdNotExists'
  }
}
